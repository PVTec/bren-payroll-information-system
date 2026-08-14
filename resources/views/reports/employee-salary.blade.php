@extends('layouts.app')

@section('title', 'Employee Salary Report')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Salary Type</label>
                <select name="salary_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="monthly" {{ request('salary_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="daily" {{ request('salary_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="hourly" {{ request('salary_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> Generate Report
                </button>
            </div>
            <div class="col-md-3">
                <button type="button" onclick="window.print()" class="btn btn-secondary w-100">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Employee Salary Details</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Type</th>
                    <th class="text-end">Basic Salary</th>
                    <th>Recent Payrolls</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td><span class="text-muted">{{ $emp->employee_id }}</span></td>
                        <td><strong>{{ $emp->full_name }}</strong></td>
                        <td>{{ $emp->department->name ?? 'N/A' }}</td>
                        <td>{{ $emp->position }}</td>
                        <td><span class="badge bg-light text-dark">{{ ucfirst($emp->salary_type) }}</span></td>
                        <td class="text-end">₱{{ number_format($emp->basic_salary, 2) }}</td>
                        <td>
                            @forelse($emp->payrolls as $payroll)
                                <small class="text-muted">{{ $payroll->payroll_period }}: ₱{{ number_format($payroll->net_pay, 2) }}</small><br>
                            @empty
                                <small class="text-muted">-</small>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No employees found matching filters</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
