<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'employee_share',
        'employer_share',
        'fixed_amount',
        'minimum_salary',
        'maximum_salary',
        'tier_data',
        'is_active',
    ];

    protected $casts = [
        'employee_share' => 'decimal:4',
        'employer_share' => 'decimal:4',
        'fixed_amount' => 'decimal:2',
        'minimum_salary' => 'decimal:2',
        'maximum_salary' => 'decimal:2',
        'tier_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function calculateEmployeeShare($baseAmount)
    {
        if ($this->type === 'fixed') {
            return $this->fixed_amount ?? 0;
        }

        if ($this->type === 'percentage') {
            return $baseAmount * ($this->employee_share / 100);
        }

        if ($this->type === 'tiered' && $this->tier_data) {
            return $this->calculateTiered($baseAmount);
        }

        return 0;
    }

    public function calculateEmployerShare($baseAmount)
    {
        if ($this->type === 'fixed') {
            return $this->fixed_amount ?? 0;
        }

        if ($this->type === 'percentage') {
            return $baseAmount * ($this->employer_share / 100);
        }

        if ($this->type === 'tiered' && $this->tier_data) {
            return $this->calculateTiered($baseAmount, 'employer');
        }

        return 0;
    }

    private function calculateTiered($baseAmount, $shareType = 'employee')
    {
        $field = $shareType . '_share';
        $tierData = $this->tier_data;

        foreach ($tierData as $tier) {
            $min = $tier['min'] ?? 0;
            $max = $tier['max'] ?? PHP_INT_MAX;
            $share = $tier[$field] ?? 0;

            if ($baseAmount >= $min && $baseAmount <= $max) {
                return $share;
            }
        }

        return 0;
    }
}
