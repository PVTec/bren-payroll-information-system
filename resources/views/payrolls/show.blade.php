@extends('layouts.app')

@section('title', 'Payroll Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payroll Details</h2>
    <div>
        <a href="{{ route('payrolls.payslip', $payroll) }}" class="btn btn-secondary" target="_blank">
            <i class="bi bi-printer"></i> Print Payslip
        </a>
        <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payroll Information</h5>
                    <span class="badge bg-{{ $payroll->status === 'paid' ? 'success' : ($payroll->status === 'processed' ? 'info' : 'warning') }} fs-6">
                        {{ ucfirst($payroll->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Employee</h6>
                        <p class="mb-1"><strong>{{ $payroll->employee->full_name }}</strong></p>
                        <p class="text-muted mb-0">{{ $payroll->employee->position }}</p>
                        <p class="text-muted">{{ $payroll->employee->department->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Payroll Period</h6>
                        <p class="mb-1"><strong>{{ $payroll->payroll_period }}</strong></p>
                        <p class="text-muted mb-0">
                            {{ $payroll->start_date->format('F d, Y') }} - {{ $payroll->end_date->format('F d, Y') }}
                        </p>
                        <p class="text-muted">{{ ucfirst($payroll->payroll_type) }} Payroll</p>
                    </div>
                </div>

                @if($payroll->processed_by)
                    <div class="alert alert-light">
                        <small class="text-muted">
                            Processed by {{ $payroll->processor->name ?? 'N/A' }} 
                            on {{ $payroll->processed_at?->format('F d, Y h:i A') }}
                        </small>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Earnings</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                @forelse($payroll->earnings as $earning)
                                    <tr>
                                        <td>{{ $earning->name }}</td>
                                        <td class="text-end">₱{{ number_format($earning->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3">No earnings</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr class="table-success">
                                    <td><strong>Total Earnings</strong></td>
                                    <td class="text-end"><strong>₱{{ number_format($payroll->gross_pay, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Deductions</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                @forelse($payroll->deductions as $deduction)
                                    <tr>
                                        <td>{{ $deduction->name }}</td>
                                        <td class="text-end">₱{{ number_format($deduction->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3">No deductions</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr class="table-danger">
                                    <td><strong>Total Deductions</strong></td>
                                    <td class="text-end"><strong>₱{{ number_format($payroll->total_deductions, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Basic Pay:</span>
                    <strong>₱{{ number_format($payroll->basic_pay, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Gross Pay:</span>
                    <strong>₱{{ number_format($payroll->gross_pay, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Deductions:</span>
                    <strong class="text-danger">-₱{{ number_format($payroll->total_deductions, 2) }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fs-5">Net Pay:</span>
                    <span class="fs-4 text-success"><strong>₱{{ number_format($payroll->net_pay, 2) }}</strong></span>
                </div>
            </div>
        </div>

        @if($payroll->isDraft())
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payrolls.process', $payroll) }}">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Process this payroll? This will finalize the calculation.')">
                            <i class="bi bi-check-circle"></i> Process Payroll
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
