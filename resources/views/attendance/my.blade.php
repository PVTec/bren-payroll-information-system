@extends('layouts.app')

@section('title', 'My Attendance')

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
    }
    .table-clean {
        margin: 0;
    }
    .table-clean th {
        font-weight: 500;
        color: #888;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.75rem 1.25rem;
        border: none;
        background: #fafafa;
    }
    .table-clean td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
        color: #444;
        vertical-align: middle;
    }
    .table-clean tbody tr:last-child td {
        border-bottom: none;
    }
    .table-clean tbody tr:hover {
        background: #fafafa;
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
    .status-leave { background: #8b5cf6; }
    .pagination-clean {
        padding: 1rem 1.25rem;
        border-top: 1px solid #f0f0f0;
    }
</style>

<h1 class="page-title">My Attendance</h1>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Hours</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                    <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->hours_worked ?: '-' }}</td>
                    <td>
                        <span class="status-dot status-{{ $attendance->status === 'half_day' ? 'halfday' : $attendance->status }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No attendance records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-clean">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
