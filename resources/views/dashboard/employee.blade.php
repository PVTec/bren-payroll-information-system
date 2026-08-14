@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
    .page-subtitle {
        color: #888;
        font-size: 0.9rem;
        margin-bottom: 2rem;
    }
    .info-row {
        display: flex;
        gap: 2rem;
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }
    .info-item {
        min-width: 120px;
    }
    .info-label {
        font-size: 0.75rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    .info-value {
        font-size: 1rem;
        color: #1a1a1a;
    }
    .card-clean {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
        margin-bottom: 1.5rem;
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
    .card-body-clean {
        padding: 1.25rem;
    }
    .row-item {
        display: flex;
        justify-content: space-between;
        padding: 0.625rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
    }
    .row-item:last-child {
        border-bottom: none;
    }
    .row-label {
        color: #666;
    }
    .row-value {
        color: #1a1a1a;
    }
    .net-pay-box {
        background: #f9f9f9;
        border-radius: 6px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .net-pay-label {
        color: #1a1a1a;
        font-weight: 500;
    }
    .net-pay-value {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d6a4f;
    }
    .attendance-row {
        display: flex;
        gap: 1.5rem;
    }
    .attendance-box {
        text-align: center;
        padding: 1rem 1.5rem;
        border-radius: 6px;
        min-width: 80px;
    }
    .attendance-present { background: #f0f9f4; }
    .attendance-absent { background: #fef2f2; }
    .attendance-late { background: #fff8e6; }
    .attendance-count {
        font-size: 1.5rem;
        font-weight: 300;
        color: #1a1a1a;
        line-height: 1;
    }
    .attendance-label {
        font-size: 0.7rem;
        color: #666;
        text-transform: uppercase;
        margin-top: 0.25rem;
    }
    .table-clean {
        margin: 0;
    }
    .table-clean th {
        font-weight: 500;
        color: #888;
        font-size: 0.75rem;
        padding: 0.75rem 1.25rem;
        border: none;
    }
    .table-clean td {
        padding: 0.75rem 1.25rem;
        border: none;
        color: #444;
        font-size: 0.9rem;
    }
    .link-clean {
        color: #666;
        font-size: 0.8rem;
        text-decoration: none;
    }
    .link-clean:hover {
        color: #1a1a1a;
    }
</style>

<h1 class="page-title">Hello, {{ $employee->first_name }}</h1>
<p class="page-subtitle">{{ now()->format('F d, Y') }}</p>

<div class="info-row">
    <div class="info-item">
        <div class="info-label">Employee ID</div>
        <div class="info-value">{{ $employee->employee_id }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Department</div>
        <div class="info-value">{{ $employee->department->name ?? '-' }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Position</div>
        <div class="info-value">{{ $employee->position }}</div>
    </div>
    <div class="info-item">
        <div class="info-label">Salary</div>
        <div class="info-value">₱{{ number_format($employee->basic_salary, 0) }} / {{ $employee->salary_type }}</div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-md-6">
        <div class="card-clean">
            <div class="card-header-clean d-flex justify-content-between align-items-center">
                <h6>Latest Payslip</h6>
                @if($latest_payroll)
                    <a href="{{ route('payrolls.payslip', $latest_payroll) }}" class="link-clean">View payslip</a>
                @endif
            </div>
            <div class="card-body-clean">
                @if($latest_payroll)
                    <div class="row-item">
                        <span class="row-label">Period</span>
                        <span class="row-value">{{ $latest_payroll->payroll_period }}</span>
                    </div>
                    <div class="row-item">
                        <span class="row-label">Basic Pay</span>
                        <span class="row-value">₱{{ number_format($latest_payroll->basic_pay, 0) }}</span>
                    </div>
                    <div class="row-item">
                        <span class="row-label">Gross Pay</span>
                        <span class="row-value">₱{{ number_format($latest_payroll->gross_pay, 0) }}</span>
                    </div>
                    <div class="row-item">
                        <span class="row-label">Deductions</span>
                        <span class="row-value">₱{{ number_format($latest_payroll->total_deductions, 0) }}</span>
                    </div>
                    <div class="net-pay-box">
                        <span class="net-pay-label">Net Pay</span>
                        <span class="net-pay-value">₱{{ number_format($latest_payroll->net_pay, 2) }}</span>
                    </div>
                @else
                    <p class="text-muted mb-0">No payslip available yet</p>
                @endif
            </div>
        </div>

        <div class="card-clean">
            <div class="card-header-clean">
                <h6>This Month's Attendance</h6>
            </div>
            <div class="card-body-clean">
                <div class="attendance-row">
                    <div class="attendance-box attendance-present">
                        <div class="attendance-count">{{ $attendance_summary['present'] ?? 0 }}</div>
                        <div class="attendance-label">Present</div>
                    </div>
                    <div class="attendance-box attendance-absent">
                        <div class="attendance-count">{{ $attendance_summary['absent'] ?? 0 }}</div>
                        <div class="attendance-label">Absent</div>
                    </div>
                    <div class="attendance-box attendance-late">
                        <div class="attendance-count">{{ $attendance_summary['late'] ?? 0 }}</div>
                        <div class="attendance-label">Late</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-clean">
            <div class="card-header-clean">
                <h6>Payroll History</h6>
            </div>
            <table class="table table-clean">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th class="text-end">Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payroll_history as $payroll)
                        <tr>
                            <td>{{ $payroll->payroll_period }}</td>
                            <td class="text-end">₱{{ number_format($payroll->net_pay, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted py-3">No payroll history</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
