<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function payrollSummary(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $payrolls = Payroll::with('employee')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where('status', '!=', 'draft')
            ->get();

        $summary = [
            'total_payrolls' => $payrolls->count(),
            'total_basic_pay' => $payrolls->sum('basic_pay'),
            'total_gross_pay' => $payrolls->sum('gross_pay'),
            'total_deductions' => $payrolls->sum('total_deductions'),
            'total_net_pay' => $payrolls->sum('net_pay'),
        ];

        $byDepartment = $payrolls->groupBy(function ($payroll) {
            return $payroll->employee->department->name ?? 'No Department';
        })->map(function ($deptPayrolls) {
            return [
                'count' => $deptPayrolls->count(),
                'net_pay' => $deptPayrolls->sum('net_pay'),
            ];
        });

        return view('reports.payroll-summary', compact('payrolls', 'summary', 'byDepartment', 'startDate', 'endDate'));
    }

    public function employeeSalary(Request $request)
    {
        $query = Employee::with(['department', 'payrolls' => function ($q) {
            $q->latest()->take(3);
        }]);

        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('salary_type') && $request->salary_type) {
            $query->where('salary_type', $request->salary_type);
        }

        $employees = $query->where('status', 'active')->get();
        $departments = Department::all();

        return view('reports.employee-salary', compact('employees', 'departments'));
    }

    public function departmentSummary()
    {
        $departments = Department::with(['employees' => function ($q) {
            $q->where('status', 'active');
        }, 'employees.payrolls'])->get();

        $summary = $departments->map(function ($dept) {
            $totalSalary = $dept->employees->sum('basic_salary');
            $avgSalary = $dept->employees->count() > 0 ? $totalSalary / $dept->employees->count() : 0;

            return [
                'department' => $dept,
                'employee_count' => $dept->employees->count(),
                'total_salary' => $totalSalary,
                'avg_salary' => $avgSalary,
            ];
        });

        return view('reports.department-summary', compact('summary'));
    }

    public function payrollHistory(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $payrolls = Payroll::where('employee_id', $request->employee_id)
            ->where('status', '!=', 'draft')
            ->latest()
            ->paginate(12);

        return view('reports.payroll-history', compact('employee', 'payrolls'));
    }
}
