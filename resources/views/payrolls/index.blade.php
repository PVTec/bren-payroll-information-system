@extends('layouts.app')

@section('title', 'Payroll')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .btn-simple {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        border: 1px solid #1a1a1a;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-simple:hover {
        background: #333;
        color: white;
    }
    .btn-simple-outline {
        background: white;
        color: #1a1a1a;
    }
    .btn-simple-outline:hover {
        background: #f5f5f5;
    }
    .filter-bar {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .input-simple {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        width: 100%;
    }
    .input-simple:focus {
        outline: none;
        border-color: #1a1a1a;
    }
    .card-clean {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
    }
    .table-clean {
        margin: 0;
    }
    .table-clean th {
        font-weight: 500;
        color: #888;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1.25rem;
        border: none;
        background: #fafafa;
    }
    .table-clean td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
        color: #444;
        vertical-align: middle;
    }
    .table-clean tbody tr:last-child td {
        border-bottom: none;
    }
    .table-clean tbody tr:hover {
        background: #fafafa;
    }
    .emp-info {
        color: #1a1a1a;
    }
    .emp-id {
        font-size: 0.8rem;
        color: #888;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-paid { background: #22c55e; }
    .status-processed { background: #3b82f6; }
    .status-draft { background: #f59e0b; }
    .action-link {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
        margin-right: 0.75rem;
    }
    .action-link:hover {
        color: #1a1a1a;
    }
    .pagination-clean {
        padding: 1rem 1.25rem;
        border-top: 1px solid #f0f0f0;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Payroll</h1>
    <div>
        <a href="{{ route('payrolls.bulk.create') }}" class="btn-simple btn-simple-outline me-2">Bulk Create</a>
        <a href="{{ route('payrolls.create') }}" class="btn-simple">Create Payroll</a>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <select name="employee_id" class="input-simple">
                <option value="">All Employees</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="period" class="input-simple">
                <option value="">All Periods</option>
                @foreach($periods as $period)
                    <option value="{{ $period }}" {{ request('period') == $period ? 'selected' : '' }}>
                        {{ $period }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="input-simple">
                <option value="">All Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-simple w-100">Filter</button>
        </div>
    </form>
</div>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Gross</th>
                <th>Deductions</th>
                <th>Net Pay</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $payroll)
                <tr>
                    <td>
                        <div class="emp-info">{{ $payroll->employee->full_name ?? '-' }}</div>
                        <div class="emp-id">{{ $payroll->employee->employee_id ?? '' }}</div>
                    </td>
                    <td>{{ $payroll->payroll_period }}</td>
                    <td>₱{{ number_format($payroll->gross_pay, 0) }}</td>
                    <td>₱{{ number_format($payroll->total_deductions, 0) }}</td>
                    <td><strong>₱{{ number_format($payroll->net_pay, 2) }}</strong></td>
                    <td>
                        <span class="status-dot status-{{ $payroll->status }}"></span>
                        {{ ucfirst($payroll->status) }}
                    </td>
                    <td>
                        <a href="{{ route('payrolls.show', $payroll) }}" class="action-link">View</a>
                        <a href="{{ route('payrolls.payslip', $payroll) }}" class="action-link" target="_blank">Payslip</a>
                        @if($payroll->isDraft())
                            <form method="POST" action="{{ route('payrolls.process', $payroll) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="action-link border-0 bg-transparent p-0" onclick="return confirm('Process this payroll?')">Process</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No payrolls found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-clean">
        {{ $payrolls->withQueryString()->links() }}
    </div>
</div>
@endsection
