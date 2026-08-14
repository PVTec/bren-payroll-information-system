@extends('layouts.app')

@section('title', 'Bulk Create Payrolls')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Bulk Create Payrolls</h2>
    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('payrolls.bulk.store') }}">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Payroll Period *</label>
                    <input type="text" name="payroll_period" class="form-control" 
                           placeholder="e.g., January 2026" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Payroll Type *</label>
                    <select name="payroll_type" class="form-select" required>
                        <option value="monthly">Monthly</option>
                        <option value="semi_monthly">Semi-Monthly</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Employees *</label>
                <div class="d-flex mb-2">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="selectAll()">Select All</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">Deselect All</button>
                </div>
                <div class="border p-3" style="max-height: 300px; overflow-y: auto;">
                    @foreach($employees as $emp)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="employee_ids[]" value="{{ $emp->id }}" id="emp_{{ $emp->id }}">
                            <label class="form-check-label" for="emp_{{ $emp->id }}">
                                {{ $emp->employee_id }} - {{ $emp->full_name }} ({{ $emp->department->name ?? 'N/A' }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Payrolls for Selected Employees</button>
        </form>
    </div>
</div>

@section('scripts')
<script>
function selectAll() {
    document.querySelectorAll('input[name="employee_ids[]"]').forEach(cb => cb.checked = true);
}
function deselectAll() {
    document.querySelectorAll('input[name="employee_ids[]"]').forEach(cb => cb.checked = false);
}
</script>
@endsection
@endsection
