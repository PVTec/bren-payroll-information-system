<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Department;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'total_employees' => Employee::where('status', 'active')->count(),
            'total_departments' => Department::count(),
            'pending_payrolls' => Payroll::where('status', 'draft')->count(),
            'processed_payrolls' => Payroll::where('status', 'processed')->count(),
        ];

        $recent_employees = Employee::with('department')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        $recent_payrolls = Payroll::with('employee')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_employees', 'recent_payrolls'));
    }

    public function staff()
    {
        $stats = [
            'total_employees' => Employee::where('status', 'active')->count(),
            'pending_payrolls' => Payroll::where('status', 'draft')->count(),
            'this_month_payrolls' => Payroll::whereMonth('created_at', now()->month)->count(),
        ];

        $recent_attendance = Attendance::with('employee')
            ->whereDate('date', today())
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.staff', compact('stats', 'recent_attendance'));
    }

    public function employee()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            abort(404, 'Employee record not found');
        }

        $latest_payroll = Payroll::where('employee_id', $employee->id)
            ->where('status', 'paid')
            ->latest()
            ->first();

        $payroll_history = Payroll::where('employee_id', $employee->id)
            ->latest()
            ->take(5)
            ->get();

        $attendance_summary = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard.employee', compact('employee', 'latest_payroll', 'payroll_history', 'attendance_summary'));
    }
}
