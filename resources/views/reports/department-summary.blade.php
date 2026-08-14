@extends('layouts.app')

@section('title', 'Department Summary')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Department Overview</h5>
        <button onclick="window.print()" class="btn btn-secondary btn-sm">
            <i class="bi bi-printer me-1"></i> Print
        </button>
    </div>
</div>

<div class="row g-3">
    @forelse($summary as $dept)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-semibold">{{ $dept['department']->name }}</h6>
                    <small class="text-muted">Code: {{ $dept['department']->code }}</small>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Employees</div>
                                <div class="fs-4 fw-semibold">{{ $dept['employee_count'] }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Avg Salary</div>
                                <div class="fs-6 fw-semibold">₱{{ number_format($dept['avg_salary'], 0) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Total Salary</span>
                            <span class="fw-semibold">₱{{ number_format($dept['total_salary'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No department data available</div>
        </div>
    @endforelse
</div>
@endsection
