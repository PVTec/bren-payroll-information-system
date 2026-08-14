@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    .btn-simple {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        border: 1px solid #1a1a1a;
        background: #1a1a1a;
        color: white;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-simple:hover {
        background: #333;
        color: white;
    }
    .btn-simple-outline {
        background: white;
        color: #1a1a1a;
    }
    .btn-simple-outline:hover {
        background: #f5f5f5;
    }
    .filter-bar {
        background: white;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .input-simple {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        width: 100%;
    }
    .input-simple:focus {
        outline: none;
        border-color: #1a1a1a;
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
    .action-link {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
        margin-right: 0.75rem;
    }
    .action-link:hover {
        color: #1a1a1a;
    }
    .pagination-clean {
        padding: 1rem 1.25rem;
        border-top: 1px solid #f0f0f0;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Attendance</h1>
    <div>
        <a href="{{ route('attendance.bulk.create') }}" class="btn-simple btn-simple-outline me-2">Bulk Entry</a>
        <a href="{{ route('attendance.create') }}" class="btn-simple">Add Record</a>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <input type="date" name="date" class="input-simple" value="{{ request('date', today()->format('Y-m-d')) }}">
        </div>
        <div class="col-md-3">
            <select name="employee_id" class="input-simple">
                <option value="">All Employees</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->full_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="input-simple">
                <option value="">All Status</option>
                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-simple w-100">Filter</button>
        </div>
    </form>
</div>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Hours</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                    <td>{{ $attendance->employee->full_name }}</td>
                    <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->hours_worked }}</td>
                    <td>
                        <span class="status-dot status-{{ $attendance->status === 'half_day' ? 'halfday' : $attendance->status }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                    </td>
                    <td>
                        <a href="{{ route('attendance.edit', $attendance) }}" class="action-link">Edit</a>
                        <form method="POST" action="{{ route('attendance.destroy', $attendance) }}" class="d-inline"
                              onsubmit="return confirm('Delete this record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link border-0 bg-transparent p-0" style="color: #c44;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No attendance records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-clean">
        {{ $attendances->withQueryString()->links() }}
    </div>
</div>
@endsection
