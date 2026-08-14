@extends('layouts.app')

@section('title', 'Add Deduction Setting')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add Deduction Setting</h2>
    <a href="{{ route('deductions.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('deductions.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., SSS Contribution" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-select" id="typeSelect" required>
                        <option value="fixed">Fixed Amount</option>
                        <option value="percentage">Percentage</option>
                        <option value="tiered">Tiered (Salary Brackets)</option>
                    </select>
                </div>
            </div>

            <div id="fixedFields" class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Fixed Amount</label>
                    <input type="number" step="0.01" name="fixed_amount" class="form-control">
                </div>
            </div>

            <div id="percentageFields" class="row mb-3" style="display: none;">
                <div class="col-md-6">
                    <label class="form-label">Employee Share (%)</label>
                    <input type="number" step="0.01" name="employee_share" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Employer Share (%)</label>
                    <input type="number" step="0.01" name="employer_share" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Minimum Salary</label>
                    <input type="number" step="0.01" name="minimum_salary" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Maximum Salary</label>
                    <input type="number" step="0.01" name="maximum_salary" class="form-control">
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Setting</button>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('typeSelect').addEventListener('change', function() {
        document.getElementById('fixedFields').style.display = this.value === 'fixed' ? 'flex' : 'none';
        document.getElementById('percentageFields').style.display = this.value === 'percentage' ? 'flex' : 'none';
    });
</script>
@endsection
@endsection
