@extends('layouts.app')

@section('title', 'Payroll History')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Payroll History</h5>
            <small class="text-muted">{{ $employee->full_name }}</small>
        </div>
        <a href="{{ route('reports.employee-salary') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Employee Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-6 mb-2">
                <small class="text-muted">Employee ID</small>
                <div class="fw-semibold">{{ $employee->employee_id }}</div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <small class="text-muted">Department</small>
                <div class="fw-semibold">{{ $employee->department->name ?? 'N/A' }}</div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <small class="text-muted">Position</small>
                <div class="fw-semibold">{{ $employee->position }}</div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <small class="text-muted">Status</small>
                <div class="fw-semibold">{{ ucfirst($employee->status) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Payroll Records</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Type</th>
                    <th>Date Range</th>
                    <th class="text-end">Gross Pay</th>
                    <th class="text-end">Deductions</th>
                    <th class="text-end">Net Pay</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->payroll_period }}</td>
                        <td><span class="badge bg-light text-dark">{{ ucfirst($payroll->payroll_type) }}</span></td>
                        <td>{{ $payroll->start_date->format('M d') }} - {{ $payroll->end_date->format('M d, Y') }}</td>
                        <td class="text-end">₱{{ number_format($payroll->gross_pay, 2) }}</td>
                        <td class="text-end">₱{{ number_format($payroll->total_deductions, 2) }}</td>
                        <td class="text-end fw-semibold">₱{{ number_format($payroll->net_pay, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'processed' ? 'info' : 'warning') }}">
                                {{ ucfirst($payroll->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No payroll history found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payrolls->hasPages())
        <div class="card-footer">
            {{ $payrolls->links() }}
        </div>
    @endif
</div>
@endsection
