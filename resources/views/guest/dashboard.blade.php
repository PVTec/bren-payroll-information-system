@extends('layouts.app')

@section('title', 'Guest Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card bg-gradient-purple text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-1">Welcome, Guest User!</h4>
                        <p class="mb-0 opacity-75">You have view-only access to the payroll system. Browse employees, payroll records, and reports.</p>
                    </div>
                    <div class="flex-shrink-0 ms-4">
                        <i class="bi bi-person-badge fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-primary">{{ $stats['total_employees'] }}</div>
                        <div class="stat-label">Total Employees</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-success">{{ $stats['active_employees'] }}</div>
                        <div class="stat-label">Active Employees</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-info">{{ $stats['total_departments'] }}</div>
                        <div class="stat-label">Departments</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-warning">{{ $stats['recent_payrolls'] }}</div>
                        <div class="stat-label">Processed Payrolls</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Payrolls</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Period</th>
                                <th class="text-end">Gross Pay</th>
                                <th class="text-end">Net Pay</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->employee->full_name ?? 'N/A' }}</td>
                                    <td>{{ $payroll->payroll_period }}</td>
                                    <td class="text-end">₱{{ number_format($payroll->gross_pay, 2) }}</td>
                                    <td class="text-end fw-medium text-success">₱{{ number_format($payroll->net_pay, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2"></i>
                                        <p class="mt-2">No processed payrolls yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="bi bi-bar-chart me-2 text-info"></i>Department Overview</h5>
            </div>
            <div class="card-body">
                @forelse($departmentStats as $dept)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted">{{ $dept->name }}</span>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="width: 60px; height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ min($dept->employees_count * 10, 100) }}%"></div>
                            </div>
                            <span class="badge bg-light text-dark">{{ $dept->employees_count }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-building fs-2"></i>
                        <p class="mt-2">No departments found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
