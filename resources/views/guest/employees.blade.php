@extends('layouts.app')

@section('title', 'Employee Directory')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Employee Directory</h5>
                    </div>
                    <div class="col-md-8">
                        <form method="GET" class="d-flex gap-2">
                            <select name="department_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search employees..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Employment Type</th>
                                <th>Join Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $employee->full_name }}</div>
                                                <small class="text-muted">{{ $employee->employee_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $employee->department?->name ?? 'N/A' }}</td>
                                    <td>{{ $employee->position ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $employee->employment_type === 'full_time' ? 'success' : ($employee->employment_type === 'part_time' ? 'info' : 'secondary') }}">
                                            {{ str_replace('_', ' ', $employee->employment_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $employee->hire_date?->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-people fs-1"></i>
                                            <p class="mt-2">No employees found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($employees->hasPages())
                <div class="card-footer bg-white">
                    {{ $employees->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
