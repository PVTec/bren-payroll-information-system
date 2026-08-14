<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'email',
        'address',
        'hire_date',
        'position',
        'salary_type',
        'basic_salary',
        'status',
        'sss_number',
        'philhealth_number',
        'pagibig_number',
        'tin_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'basic_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getDailyRateAttribute()
    {
        return match($this->salary_type) {
            'monthly' => $this->basic_salary / 22,
            'daily' => $this->basic_salary,
            'hourly' => $this->basic_salary * 8,
            default => $this->basic_salary / 22,
        };
    }

    public function getHourlyRateAttribute()
    {
        return match($this->salary_type) {
            'monthly' => $this->basic_salary / 22 / 8,
            'daily' => $this->basic_salary / 8,
            'hourly' => $this->basic_salary,
            default => $this->basic_salary / 22 / 8,
        };
    }
}
