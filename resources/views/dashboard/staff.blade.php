@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .stat-simple {
        padding: 1.25rem 0;
        border-bottom: 1px solid #eee;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 300;
        color: #1a1a1a;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.875rem;
        color: #666;
        margin-top: 0.25rem;
    }
    .card-clean {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
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
    .table-clean {
        margin: 0;
    }
    .table-clean th {
        font-weight: 500;
        color: #666;
        font-size: 0.8rem;
        padding: 0.75rem 1.25rem;
        border: none;
    }
    .table-clean td {
        padding: 0.875rem 1.25rem;
        border: none;
        color: #444;
        font-size: 0.9rem;
    }
    .table-clean tbody tr:hover {
        background: #fafafa;
    }
    .btn-simple {
        font-size: 0.8rem;
        padding: 0.4rem 0.875rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        background: white;
        color: #555;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-simple:hover {
        background: #f5f5f5;
        color: #1a1a1a;
    }
    .btn-simple-primary {
        background: #1a1a1a;
        color: white;
        border-color: #1a1a1a;
    }
    .btn-simple-primary:hover {
        background: #333;
        color: white;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-present { background: #22c55e; }
    .status-absent { background: #ef4444; }
    .status-late { background: #f59e0b; }
    .status-halfday { background: #3b82f6; }
</style>

<h1 class="page-title">Staff Dashboard</h1>

<div class="row g-3 mb-4">
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['total_employees'] }}</div>
            <div class="stat-label">Employees</div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['pending_payrolls'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-simple">
            <div class="stat-number">{{ $stats['this_month_payrolls'] }}</div>
            <div class="stat-label">This Month</div>
        </div>
    </div>
</div>

<div class="card-clean">
    <div class="card-header-clean d-flex justify-content-between align-items-center">
        <h6>Today's Attendance</h6>
        <div>
            <a href="{{ route('attendance.bulk.create') }}" class="btn-simple me-2">Bulk entry</a>
            <a href="{{ route('attendance.index') }}" class="btn-simple btn-simple-primary">View all</a>
        </div>
    </div>
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
                <th>Hours</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_attendance as $attendance)
                <tr>
                    <td>{{ $attendance->employee->full_name ?? '-' }}</td>
                    <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                    <td>
                        <span class="status-dot status-{{ $attendance->status }}"></span>
                        {{ ucfirst($attendance->status) }}
                    </td>
                    <td>{{ $attendance->hours_worked ?? '0' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-muted py-3">No attendance records for today</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
