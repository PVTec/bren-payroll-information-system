<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'hours_worked',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i',
        'hours_worked' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function booted()
    {
        static::saving(function ($attendance) {
            if ($attendance->time_in && $attendance->time_out) {
                $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                $timeOut = \Carbon\Carbon::parse($attendance->time_out);
                $diffInHours = $timeIn->diffInHours($timeOut);
                $attendance->hours_worked = min($diffInHours, 8);
            }
        });
    }
}
