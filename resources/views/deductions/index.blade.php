@extends('layouts.app')

@section('title', 'Deduction Rules')

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
    .status-active { background: #22c55e; }
    .status-inactive { background: #9ca3af; }
    .action-link {
        color: #666;
        font-size: 0.85rem;
        text-decoration: none;
        margin-right: 0.75rem;
    }
    .action-link:hover {
        color: #1a1a1a;
    }
    .info-text {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Deduction Rules</h1>
    <a href="{{ route('deductions.create') }}" class="btn-simple">Add Rule</a>
</div>

<div class="card-clean">
    <table class="table table-clean">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Employee Share</th>
                <th>Employer Share</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($settings as $setting)
                <tr>
                    <td>{{ $setting->name }}</td>
                    <td>{{ ucfirst($setting->type) }}</td>
                    <td>
                        @if($setting->type == 'fixed')
                            ₱{{ number_format($setting->fixed_amount, 0) }}
                        @elseif($setting->type == 'percentage')
                            {{ $setting->employee_share }}%
                        @else
                            Tiered
                        @endif
                    </td>
                    <td>
                        @if($setting->employer_share)
                            {{ $setting->employer_share }}%
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="status-dot status-{{ $setting->is_active ? 'active' : 'inactive' }}"></span>
                        {{ $setting->is_active ? 'Active' : 'Inactive' }}
                    </td>
                    <td>
                        <a href="{{ route('deductions.edit', $setting) }}" class="action-link">Edit</a>
                        <form method="POST" action="{{ route('deductions.destroy', $setting) }}" class="d-inline"
                              onsubmit="return confirm('Delete this rule?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link action-delete border-0 bg-transparent p-0" style="color: #c44;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No deduction rules found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card-clean">
    <div class="card-header-clean">
        <h6>Rule Types</h6>
    </div>
    <div class="p-3">
        <p class="info-text"><strong>Fixed:</strong> Fixed amount deducted from all employees</p>
        <p class="info-text"><strong>Percentage:</strong> Percentage of gross pay</p>
        <p class="info-text mb-0"><strong>Tiered:</strong> Amount based on salary brackets (e.g., SSS)</p>
    </div>
</div>
@endsection
