@extends('layouts.app')

@section('title', 'Payroll Records')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-gradient-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 opacity-75">Total Gross Pay</h6>
                                <h4 class="mb-0 mt-1">₱{{ number_format($summary['total_gross'], 2) }}</h4>
                            </div>
                            <div class="opacity-50">
                                <i class="bi bi-graph-up fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 opacity-75">Total Deductions</h6>
                                <h4 class="mb-0 mt-1">₱{{ number_format($summary['total_deductions'], 2) }}</h4>
                            </div>
                            <div class="opacity-50">
                                <i class="bi bi-graph-down fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-gradient-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0 opacity-75">Total Net Pay</h6>
                                <h4 class="mb-0 mt-1">₱{{ number_format($summary['total_net'], 2) }}</h4>
                            </div>
                            <div class="opacity-50">
                                <i class="bi bi-cash-coin fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="bi bi-cash-stack me-2 text-primary"></i>Payroll Records</h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <form method="GET" class="d-inline-flex gap-2">
                            <select name="period" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Periods</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period }}" {{ request('period') == $period ? 'selected' : '' }}>{{ $period }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Period</th>
                                <th>Payroll Type</th>
                                <th class="text-end">Gross Pay</th>
                                <th class="text-end">Deductions</th>
                                <th class="text-end">Net Pay</th>
                                <th>Processed Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->employee->full_name ?? 'N/A' }}</td>
                                    <td>{{ $payroll->payroll_period }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ str_replace('_', ' ', $payroll->payroll_type) }}
                                        </span>
                                    </td>
                                    <td class="text-end">₱{{ number_format($payroll->gross_pay, 2) }}</td>
                                    <td class="text-end text-danger">₱{{ number_format($payroll->total_deductions, 2) }}</td>
                                    <td class="text-end fw-medium text-success">₱{{ number_format($payroll->net_pay, 2) }}</td>
                                    <td>{{ $payroll->updated_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1"></i>
                                            <p class="mt-2">No payroll records found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($payrolls->hasPages())
                <div class="card-footer bg-white">
                    {{ $payrolls->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
