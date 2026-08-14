@extends('layouts.app')

@section('title', 'View Reports')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Overview Reports</h4>
        <p class="text-muted">View-only access to system statistics and summaries</p>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Employee Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h3 class="mb-0 text-primary">{{ $employeeStats['total'] }}</h3>
                            <small class="text-muted">Total Employees</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded">
                            <h3 class="mb-0 text-success">{{ $employeeStats['active'] }}</h3>
                            <small class="text-muted">Active Employees</small>
                        </div>
                    </div>
                </div>

                <h6 class="text-muted mb-3">By Employment Type</h6>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-briefcase me-2 text-success"></i>Full Time</span>
                        <span class="badge bg-success rounded-pill">{{ $employeeStats['by_type']['full_time'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-clock me-2 text-info"></i>Part Time</span>
                        <span class="badge bg-info rounded-pill">{{ $employeeStats['by_type']['part_time'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-file-text me-2 text-secondary"></i>Contract</span>
                        <span class="badge bg-secondary rounded-pill">{{ $employeeStats['by_type']['contract'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-cash-coin me-2 text-success"></i>Payroll Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2">
                        <span class="text-muted">Total Processed Payrolls</span>
                        <h5 class="mb-0">{{ $payrollStats['total_processed'] }}</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2">
                        <span class="text-muted">Total Gross Payout</span>
                        <h5 class="mb-0 text-success">₱{{ number_format($payrollStats['total_gross'], 2) }}</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                        <span class="text-muted">Total Net Payout</span>
                        <h5 class="mb-0 text-primary">₱{{ number_format($payrollStats['total_net'], 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-building me-2 text-info"></i>Department Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Department</th>
                                <th class="text-center">Employee Count</th>
                                <th class="text-end">Average Salary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departmentSummaries as $summary)
                                <tr>
                                    <td>
                                        <i class="bi bi-building me-2 text-muted"></i>{{ $summary['name'] }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $summary['employee_count'] }}</span>
                                    </td>
                                    <td class="text-end">₱{{ number_format($summary['avg_salary'], 2) }}</td>
                                    <td>
                                        @if($summary['employee_count'] > 0)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">No Staff</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">No department data available</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
