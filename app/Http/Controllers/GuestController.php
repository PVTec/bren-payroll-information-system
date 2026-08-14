<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'total_departments' => Department::count(),
            'recent_payrolls' => Payroll::where('status', 'processed')->count(),
        ];

        $recentPayrolls = Payroll::with('employee')
            ->where('status', 'processed')
            ->latest()
            ->take(5)
            ->get();

        $departmentStats = Department::withCount('employees')
            ->orderBy('employees_count', 'desc')
            ->take(5)
            ->get();

        return view('guest.dashboard', compact('stats', 'recentPayrolls', 'departmentStats'));
    }

    public function employees(Request $request)
    {
        $query = Employee::with('department')->where('status', 'active');

        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('last_name')->paginate(20);
        $departments = Department::orderBy('name')->get();

        return view('guest.employees', compact('employees', 'departments'));
    }

    public function payrolls(Request $request)
    {
        $query = Payroll::with('employee')->where('status', 'processed');

        if ($request->has('period') && $request->period) {
            $query->where('payroll_period', $request->period);
        }

        $payrolls = $query->latest()->paginate(20);
        $periods = Payroll::distinct()->pluck('payroll_period');

        $summary = [
            'total_gross' => $query->sum('gross_pay'),
            'total_deductions' => $query->sum('total_deductions'),
            'total_net' => $query->sum('net_pay'),
        ];

        return view('guest.payrolls', compact('payrolls', 'periods', 'summary'));
    }

    public function reports()
    {
        $employeeStats = [
            'total' => Employee::count(),
            'active' => Employee::where('status', 'active')->count(),
            'by_type' => [
                'full_time' => Employee::where('employment_type', 'full_time')->count(),
                'part_time' => Employee::where('employment_type', 'part_time')->count(),
                'contract' => Employee::where('employment_type', 'contract')->count(),
            ],
        ];

        $payrollStats = [
            'total_processed' => Payroll::where('status', 'processed')->count(),
            'total_gross' => Payroll::sum('gross_pay'),
            'total_net' => Payroll::sum('net_pay'),
        ];

        $departmentSummaries = Department::with(['employees' => function($q) {
            $q->where('status', 'active');
        }])->get()->map(function($dept) {
            return [
                'name' => $dept->name,
                'employee_count' => $dept->employees->count(),
                'avg_salary' => $dept->employees->avg('basic_salary') ?? 0,
            ];
        });

        return view('guest.reports', compact('employeeStats', 'payrollStats', 'departmentSummaries'));
    }
}
