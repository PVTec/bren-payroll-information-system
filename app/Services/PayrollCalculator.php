<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\DeductionSetting;
use App\Models\Attendance;
use Carbon\Carbon;

class PayrollCalculator
{
    private $payroll;
    private $employee;
    private $startDate;
    private $endDate;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
        $this->employee = $payroll->employee;
        $this->startDate = Carbon::parse($payroll->start_date);
        $this->endDate = Carbon::parse($payroll->end_date);
    }

    public function calculate(): array
    {
        $basicPay = $this->calculateBasicPay();
        $attendanceDeductions = $this->calculateAttendanceDeductions();
        $grossPay = $basicPay - $attendanceDeductions;

        $earnings = [
            ['category' => 'basic_salary', 'name' => 'Basic Salary', 'amount' => $basicPay],
        ];

        $earnings = array_merge($earnings, $this->calculateOvertime());
        $earnings = array_merge($earnings, $this->calculateBonuses());

        $grossPay = collect($earnings)->where('type', 'earning')->sum('amount');

        $deductions = $this->calculateDeductions($grossPay);
        $deductions = array_merge($deductions, $this->calculateAttendanceDeductionsAsItems());

        $totalDeductions = collect($deductions)->sum('amount');
        $netPay = $grossPay - $totalDeductions;

        return [
            'basic_pay' => $basicPay,
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
            'earnings' => $earnings,
            'deductions' => $deductions,
        ];
    }

    private function calculateBasicPay(): float
    {
        $daysInPeriod = $this->startDate->diffInDays($this->endDate) + 1;
        $workingDays = min($daysInPeriod, 22);

        return match($this->employee->salary_type) {
            'monthly' => $this->employee->basic_salary,
            'daily' => $this->employee->basic_salary * $workingDays,
            'hourly' => $this->employee->basic_salary * $workingDays * 8,
            default => $this->employee->basic_salary,
        };
    }

    private function calculateAttendanceDeductions(): float
    {
        $attendances = Attendance::where('employee_id', $this->employee->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->get();

        $dailyRate = $this->employee->daily_rate;
        $hourlyRate = $this->employee->hourly_rate;
        $totalDeduction = 0;

        foreach ($attendances as $attendance) {
            switch ($attendance->status) {
                case 'absent':
                    $totalDeduction += $dailyRate;
                    break;
                case 'half_day':
                    $totalDeduction += $dailyRate * 0.5;
                    break;
                case 'late':
                    $lateHours = $this->calculateLateHours($attendance);
                    $totalDeduction += $hourlyRate * $lateHours;
                    break;
            }
        }

        return $totalDeduction;
    }

    private function calculateLateHours(Attendance $attendance): float
    {
        if (!$attendance->time_in) return 0;

        $expectedTimeIn = Carbon::parse($attendance->date . ' 08:00:00');
        $actualTimeIn = Carbon::parse($attendance->time_in);

        if ($actualTimeIn->lte($expectedTimeIn)) return 0;

        $diffInMinutes = $expectedTimeIn->diffInMinutes($actualTimeIn);
        return ceil($diffInMinutes / 60);
    }

    private function calculateAttendanceDeductionsAsItems(): array
    {
        $attendances = Attendance::where('employee_id', $this->employee->id)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->get();

        $dailyRate = $this->employee->daily_rate;
        $hourlyRate = $this->employee->hourly_rate;
        $items = [];

        $absentDays = $attendances->where('status', 'absent')->count();
        $halfDays = $attendances->where('status', 'half_day')->count();
        $lateDays = $attendances->where('status', 'late')->count();

        if ($absentDays > 0) {
            $items[] = [
                'type' => 'deduction',
                'category' => 'absence',
                'name' => "Absence Deduction ({$absentDays} days)",
                'amount' => $dailyRate * $absentDays,
            ];
        }

        if ($halfDays > 0) {
            $items[] = [
                'type' => 'deduction',
                'category' => 'absence',
                'name' => "Half-day Deduction ({$halfDays} days)",
                'amount' => $dailyRate * 0.5 * $halfDays,
            ];
        }

        if ($lateDays > 0) {
            $lateHours = 0;
            foreach ($attendances->where('status', 'late') as $attendance) {
                $lateHours += $this->calculateLateHours($attendance);
            }

            if ($lateHours > 0) {
                $items[] = [
                    'type' => 'deduction',
                    'category' => 'late',
                    'name' => "Late Deduction ({$lateHours} hours)",
                    'amount' => $hourlyRate * $lateHours,
                ];
            }
        }

        return $items;
    }

    private function calculateOvertime(): array
    {
        return [];
    }

    private function calculateBonuses(): array
    {
        return [];
    }

    private function calculateDeductions(float $grossPay): array
    {
        $deductions = [];
        $settings = DeductionSetting::active()->get();

        foreach ($settings as $setting) {
            $amount = $setting->calculateEmployeeShare($grossPay);

            if ($amount > 0) {
                $deductions[] = [
                    'type' => 'deduction',
                    'category' => $this->getCategoryFromName($setting->name),
                    'name' => $setting->name,
                    'amount' => $amount,
                ];
            }
        }

        $withholdingTax = $this->calculateWithholdingTax($grossPay, $deductions);
        if ($withholdingTax > 0) {
            $deductions[] = [
                'type' => 'deduction',
                'category' => 'tax',
                'name' => 'Withholding Tax',
                'amount' => $withholdingTax,
            ];
        }

        return $deductions;
    }

    private function getCategoryFromName(string $name): string
    {
        $name = strtolower($name);

        if (str_contains($name, 'sss')) return 'sss';
        if (str_contains($name, 'philhealth')) return 'philhealth';
        if (str_contains($name, 'pagibig') || str_contains($name, 'pag-ibig')) return 'pagibig';

        return 'other_deductions';
    }

    private function calculateWithholdingTax(float $grossPay, array $existingDeductions): float
    {
        $taxableIncome = $grossPay;

        foreach ($existingDeductions as $deduction) {
            if (in_array($deduction['category'], ['sss', 'philhealth', 'pagibig'])) {
                $taxableIncome -= $deduction['amount'];
            }
        }

        if ($taxableIncome <= 20833) {
            return 0;
        } elseif ($taxableIncome <= 33333) {
            return ($taxableIncome - 20833) * 0.15;
        } elseif ($taxableIncome <= 66667) {
            return 1875 + ($taxableIncome - 33333) * 0.20;
        } elseif ($taxableIncome <= 166667) {
            return 8541.67 + ($taxableIncome - 66667) * 0.25;
        } elseif ($taxableIncome <= 666667) {
            return 33541.67 + ($taxableIncome - 166667) * 0.30;
        } else {
            return 183541.67 + ($taxableIncome - 666667) * 0.35;
        }
    }

    public static function getWorkingDaysInPeriod(Carbon $startDate, Carbon $endDate): int
    {
        $days = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            if (!$current->isWeekend()) {
                $days++;
            }
            $current->addDay();
        }

        return $days;
    }
}
