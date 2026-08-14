@extends('layouts.app')

@section('title', 'Payroll Summary Report')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Report</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small text-muted">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}" required>
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

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Payrolls</div>
                    <div class="stat-value">{{ $summary['total_payrolls'] }}</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-file-text"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Gross Pay</div>
                    <div class="stat-value">₱{{ number_format($summary['total_gross_pay'], 0) }}</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Deductions</div>
                    <div class="stat-value">₱{{ number_format($summary['total_deductions'], 0) }}</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-calculator"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Net Pay</div>
                    <div class="stat-value text-success">₱{{ number_format($summary['total_net_pay'], 0) }}</div>
                </div>
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-wallet"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Department Summary</h5>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Employees</th>
                    <th class="text-end">Total Net Pay</th>
                </tr>
            </thead>
            <tbody>
                @forelse($byDepartment as $dept => $data)
                    <tr>
                        <td><strong>{{ $dept }}</strong></td>
                        <td>{{ $data['count'] }}</td>
                        <td class="text-end">₱{{ number_format($data['net_pay'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No payroll data found for selected period</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
