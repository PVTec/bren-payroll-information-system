@extends('layouts.app')

@section('title', 'My Payslips')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .card-clean {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
        margin-bottom: 1rem;
        padding: 1.25rem;
    }
    .payslip-period {
        font-size: 1rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 0.25rem;
    }
    .payslip-date {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 1rem;
    }
    .amount-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
    }
    .amount-row:last-child {
        border-bottom: none;
    }
    .amount-label {
        color: #666;
    }
    .amount-value {
        color: #1a1a1a;
    }
    .net-pay {
        background: #f9f9f9;
        border-radius: 6px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .net-pay-label {
        font-weight: 500;
        color: #1a1a1a;
    }
    .net-pay-value {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d6a4f;
    }
    .action-link {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
    }
    .action-link:hover {
        color: #1a1a1a;
    }
    .pagination-clean {
        padding: 1rem 0;
    }
</style>

<h1 class="page-title">My Payslips</h1>

@forelse($payrolls as $payroll)
    <div class="card-clean">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="payslip-period">{{ $payroll->payroll_period }}</div>
                <div class="payslip-date">{{ $payroll->start_date->format('M d') }} - {{ $payroll->end_date->format('M d, Y') }}</div>
            </div>
            <a href="{{ route('payrolls.payslip', $payroll) }}" class="action-link" target="_blank">View Payslip</a>
        </div>

        <div class="amount-row">
            <span class="amount-label">Basic Pay</span>
            <span class="amount-value">₱{{ number_format($payroll->basic_pay, 0) }}</span>
        </div>
        <div class="amount-row">
            <span class="amount-label">Gross Pay</span>
            <span class="amount-value">₱{{ number_format($payroll->gross_pay, 0) }}</span>
        </div>
        <div class="amount-row">
            <span class="amount-label">Deductions</span>
            <span class="amount-value">₱{{ number_format($payroll->total_deductions, 0) }}</span>
        </div>

        <div class="net-pay">
            <span class="net-pay-label">Net Pay</span>
            <span class="net-pay-value">₱{{ number_format($payroll->net_pay, 2) }}</span>
        </div>
    </div>
@empty
    <div class="card-clean text-center py-4">
        <p class="text-muted mb-0">No payslips found</p>
    </div>
@endforelse

<div class="pagination-clean">
    {{ $payrolls->links() }}
</div>
@endsection
