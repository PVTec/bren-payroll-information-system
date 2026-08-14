@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Employee Details</h2>
    <div>
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Profile</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 80px;"></i>
                </div>
                <h4>{{ $employee->full_name }}</h4>
                <p class="text-muted mb-2">{{ $employee->position }}</p>
                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : ($employee->status === 'inactive' ? 'warning' : 'danger') }} fs-6">
                    {{ ucfirst($employee->status) }}
                </span>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <span>Employee ID</span>
                    <strong>{{ $employee->employee_id }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Department</span>
                    <strong>{{ $employee->department->name ?? 'N/A' }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Email</span>
                    <strong>{{ $employee->email }}</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Contact</span>
                    <strong>{{ $employee->contact_number }}</strong>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Salary Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Salary Type:</span>
                    <strong>{{ ucfirst($employee->salary_type) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Basic Salary:</span>
                    <strong>₱{{ number_format($employee->basic_salary, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Daily Rate:</span>
                    <strong>₱{{ number_format($employee->daily_rate, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Hourly Rate:</span>
                    <strong>₱{{ number_format($employee->hourly_rate, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="employeeTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#government">Government IDs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#payrolls">Payroll History</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="personal">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Full Name:</strong></td>
                                <td>{{ $employee->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth:</strong></td>
                                <td>{{ $employee->date_of_birth->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender:</strong></td>
                                <td>{{ ucfirst($employee->gender) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td>{{ $employee->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Hire Date:</strong></td>
                                <td>{{ $employee->hire_date->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Years of Service:</strong></td>
                                <td>{{ $employee->hire_date->diffInYears(now()) }} years</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="government">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>SSS Number:</strong></td>
                                <td>{{ $employee->sss_number ?: 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td><strong>PhilHealth Number:</strong></td>
                                <td>{{ $employee->philhealth_number ?: 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pag-IBIG Number:</strong></td>
                                <td>{{ $employee->pagibig_number ?: 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td><strong>TIN Number:</strong></td>
                                <td>{{ $employee->tin_number ?: 'Not provided' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="payrolls">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Gross Pay</th>
                                        <th>Deductions</th>
                                        <th>Net Pay</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employee->payrolls->take(10) as $payroll)
                                        <tr>
                                            <td>{{ $payroll->payroll_period }}</td>
                                            <td>₱{{ number_format($payroll->gross_pay, 2) }}</td>
                                            <td>₱{{ number_format($payroll->total_deductions, 2) }}</td>
                                            <td>₱{{ number_format($payroll->net_pay, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'processed' ? 'info' : 'warning') }}">
                                                    {{ ucfirst($payroll->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No payroll records</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
