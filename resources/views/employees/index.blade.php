@extends('layouts.app')

@section('title', 'Employees')

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
    .emp-name {
        color: #1a1a1a;
        font-weight: 500;
    }
    .emp-email {
        font-size: 0.8rem;
        color: #888;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .status-active { background: #22c55e; }
    .status-inactive { background: #f59e0b; }
    .status-terminated { background: #ef4444; }
    .action-link {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
        margin-right: 0.75rem;
    }
    .action-link:hover {
        color: #1a1a1a;
    }
    .action-delete {
        color: #c44;
    }
    .action-delete:hover {
        color: #a33;
    }
    .pagination-clean {
        padding: 1rem 1.25rem;
        border-top: 1px solid #f0f0f0;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Employees</h1>
    <a href="{{ route('employees.create') }}" class="btn-simple">Add Employee</a>
</div>

<div class="filter-bar">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="input-simple" placeholder="Search by name, ID, email..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="department" class="input-simple">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="input-simple">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-simple w-100">Filter</button>
        </div>
    </form>
</div>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Position</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->employee_id }}</td>
                    <td>
                        <div class="emp-name">{{ $employee->full_name }}</div>
                        <div class="emp-email">{{ $employee->email }}</div>
                    </td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>
                        <span class="status-dot status-{{ $employee->status }}"></span>
                        {{ ucfirst($employee->status) }}
                    </td>
                    <td>
                        <a href="{{ route('employees.show', $employee) }}" class="action-link">View</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="action-link">Edit</a>
                        <form method="POST" action="{{ route('employees.destroy', $employee) }}" class="d-inline"
                              onsubmit="return confirm('Terminate this employee?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link action-delete border-0 bg-transparent p-0">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No employees found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-clean">
        {{ $employees->withQueryString()->links() }}
    </div>
</div>
@endsection
