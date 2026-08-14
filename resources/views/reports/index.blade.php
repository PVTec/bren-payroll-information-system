@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
    .report-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
        padding: 1.25rem;
        transition: all 0.15s ease;
    }
    .report-card:hover {
        border-color: #d0d0d0;
    }
    .report-title {
        font-size: 1rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 0.25rem;
    }
    .report-desc {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 1rem;
    }
    .report-link {
        font-size: 0.85rem;
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 500;
    }
    .report-link:hover {
        color: #555;
    }
</style>

<h1 class="page-title">Reports</h1>

<div class="reports-grid">
    <div class="report-card">
        <div class="report-title">Payroll Summary</div>
        <div class="report-desc">View payroll totals by date range</div>
        <a href="{{ route('reports.payroll-summary', ['start_date' => now()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->endOfMonth()->format('Y-m-d')]) }}" class="report-link">View Report &rarr;</a>
    </div>

    <div class="report-card">
        <div class="report-title">Employee Salary</div>
        <div class="report-desc">Salary details by employee</div>
        <a href="{{ route('reports.employee-salary') }}" class="report-link">View Report &rarr;</a>
    </div>

    <div class="report-card">
        <div class="report-title">Department Summary</div>
        <div class="report-desc">Stats by department</div>
        <a href="{{ route('reports.department-summary') }}" class="report-link">View Report &rarr;</a>
    </div>

    <div class="report-card">
        <div class="report-title">Payroll History</div>
        <div class="report-desc">Employee payroll records</div>
        <a href="{{ route('employees.index') }}" class="report-link">Select Employee &rarr;</a>
    </div>
</div>
@endsection
