@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .stat-simple {
        padding: 1.25rem 0;
        border-bottom: 1px solid #eee;
    }
    .stat-simple:last-child {
        border-bottom: none;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 300;
        color: #1a1a1a;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.875rem;
        color: #666;
        margin-top: 0.25rem;
    }
    .card-clean {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
    }
    .card-header-clean {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .card-header-clean h6 {
        font-weight: 500;
        color: #1a1a1a;
        margin: 0;
    }
    .table-clean {
        margin: 0;
    }
    .table-clean th {
        font-weight: 500;
        color: #666;
        font-size: 0.8rem;
        padding: 0.75rem 1.25rem;
        border: none;
    }
    .table-clean td {
        padding: 0.875rem 1.25rem;
        border: none;
        color: #444;
        font-size: 0.9rem;
    }
    .table-clean tbody tr:hover {
        background: #fafafa;
    }
    .link-clean {
        color: #666;
        font-size: 0.8rem;
        text-decoration: none;
    }
    .link-clean:hover {
        color: #1a1a1a;
    }
    .badge-soft {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 400;
    }
    .badge-soft-success { background: #f0f9f4; color: #2d6a4f; }
    .badge-soft-warning { background: #fff8e1; color: #b8860b; }
    .badge-soft-info { background: #e8f4f8; color: #1a5276; }
</style>

<h1 class="page-title">Dashboard</h1>

<div class="row g-3">
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['total_employees'] }}</div>
            <div class="stat-label">Employees</div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['total_departments'] }}</div>
            <div class="stat-label">Departments</div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['pending_payrolls'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['processed_payrolls'] }}</div>
            <div class="stat-label">Processed</div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <div class="card-clean">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <h6>Recent Employees</h6>
                <a href="{{ route('employees.index') }}" class="link-clean">View all</a>
            </div>
            <table class="table table-clean">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_employees as $employee)
                        <tr>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->department->name ?? '-' }}</td>
                            <td>{{ $employee->position }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted py-3">No employees</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-clean">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <h6>Recent Payrolls</h6>
                <a href="{{ route('payrolls.index') }}" class="link-clean">View all</a>
            </div>
            <table class="table table-clean">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->employee->full_name ?? '-' }}</td>
                            <td>{{ $payroll->payroll_period }}</td>
                            <td>₱{{ number_format($payroll->net_pay, 0) }}</td>
                            <td>
                                <span class="badge-soft badge-soft-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'processed' ? 'info' : 'warning') }}">
                                    {{ $payroll->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted py-3">No payrolls</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
