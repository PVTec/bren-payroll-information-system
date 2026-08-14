@extends('layouts.app')

@section('title', 'Create Payroll')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create New Payroll</h2>
    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('payrolls.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Employee *</label>
                    <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->employee_id }} - {{ $emp->full_name }} ({{ $emp->position }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Payroll Period *</label>
                    <input type="text" name="payroll_period" class="form-control @error('payroll_period') is-invalid @enderror" 
                           placeholder="e.g., January 2026" value="{{ old('payroll_period') }}" required>
                    @error('payroll_period')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                           value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                           value="{{ old('end_date') }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Payroll Type *</label>
                    <select name="payroll_type" class="form-select @error('payroll_type') is-invalid @enderror" required>
                        <option value="monthly" {{ old('payroll_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="semi_monthly" {{ old('payroll_type') == 'semi_monthly' ? 'selected' : '' }}>Semi-Monthly</option>
                        <option value="weekly" {{ old('payroll_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    </select>
                    @error('payroll_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Payroll will be automatically calculated based on employee salary type, attendance records, and configured deductions.
            </div>

            <button type="submit" class="btn btn-primary">Create & Calculate Payroll</button>
        </form>
    </div>
</div>
@endsection
