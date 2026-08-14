<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department', 'user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $employees = $query->latest()->paginate(15);
        $departments = Department::all();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|unique:employees',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees|unique:users',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'salary_type' => 'required|in:monthly,daily,hourly',
            'basic_salary' => 'required|numeric|min:0',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'hire_date' => 'required|date',
            'sss_number' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
            'pagibig_number' => 'nullable|string|max:20',
            'tin_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
        ]);

        $validated['user_id'] = $user->id;
        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully. They can now login with their email and password.');
    }

    public function show(Employee $employee)
    {
        $employee->load('department', 'user', 'payrolls', 'attendances');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_id' => ['required', Rule::unique('employees')->ignore($employee->id)],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('employees')->ignore($employee->id)],
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
            'salary_type' => 'required|in:monthly,daily,hourly',
            'basic_salary' => 'required|numeric|min:0',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive,terminated',
            'sss_number' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
            'pagibig_number' => 'nullable|string|max:20',
            'tin_number' => 'nullable|string|max:20',
        ]);

        $employee->update($validated);

        if ($employee->user) {
            $employee->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'terminated']);

        return redirect()->route('employees.index')
            ->with('success', 'Employee terminated successfully');
    }
}
