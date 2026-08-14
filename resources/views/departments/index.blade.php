@extends('layouts.app')

@section('title', 'Departments')

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
    .code-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        background: #f0f0f0;
        color: #666;
        border-radius: 4px;
        font-family: monospace;
    }
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
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn-simple">Add Department</a>
</div>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Employees</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
                <tr>
                    <td><span class="code-badge">{{ $dept->code }}</span></td>
                    <td>{{ $dept->name }}</td>
                    <td>{{ Str::limit($dept->description, 50) }}</td>
                    <td>{{ $dept->employees_count }}</td>
                    <td>
                        <a href="{{ route('departments.edit', $dept) }}" class="action-link">Edit</a>
                        <form method="POST" action="{{ route('departments.destroy', $dept) }}" class="d-inline"
                              onsubmit="return confirm('Delete this department?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link action-delete border-0 bg-transparent p-0" {{ $dept->employees_count > 0 ? 'disabled' : '' }}>Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No departments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
