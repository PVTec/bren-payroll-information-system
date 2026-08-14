<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'type',
        'name',
        'category',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function isEarning()
    {
        return $this->type === 'earning';
    }

    public function isDeduction()
    {
        return $this->type === 'deduction';
    }

    public const CATEGORIES = [
        'earning' => [
            'basic_salary' => 'Basic Salary',
            'overtime' => 'Overtime Pay',
            'holiday_pay' => 'Holiday Pay',
            'night_differential' => 'Night Differential',
            'bonus' => 'Bonus',
            'allowance' => 'Allowance',
            'commission' => 'Commission',
            'incentive' => 'Incentive',
            'other_earnings' => 'Other Earnings',
        ],
        'deduction' => [
            'tax' => 'Withholding Tax',
            'sss' => 'SSS Contribution',
            'philhealth' => 'PhilHealth',
            'pagibig' => 'Pag-IBIG',
            'sss_loan' => 'SSS Loan',
            'pagibig_loan' => 'Pag-IBIG Loan',
            'absence' => 'Absence Deduction',
            'late' => 'Late Deduction',
            'undertime' => 'Undertime Deduction',
            'other_deductions' => 'Other Deductions',
        ],
    ];
}
