<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payroll_period',
        'start_date',
        'end_date',
        'payroll_type',
        'basic_pay',
        'gross_pay',
        'total_deductions',
        'net_pay',
        'status',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'processed_at' => 'datetime',
        'basic_pay' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function earnings()
    {
        return $this->items()->where('type', 'earning');
    }

    public function deductions()
    {
        return $this->items()->where('type', 'deduction');
    }

    public function getTotalEarningsAttribute()
    {
        return $this->earnings()->sum('amount');
    }

    public function getTotalDeductionsAttribute()
    {
        return $this->deductions()->sum('amount');
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isProcessed()
    {
        return $this->status === 'processed';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function markAsProcessed($userId)
    {
        $this->update([
            'status' => 'processed',
            'processed_at' => now(),
            'processed_by' => $userId,
        ]);
    }

    public function markAsPaid()
    {
        $this->update(['status' => 'paid']);
    }
}
