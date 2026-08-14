@extends('layouts.app')

@section('title', 'Add Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add Attendance Record</h2>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Employee *</label>
                    <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->employee_id }} - {{ $emp->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                           value="{{ old('date', today()->format('Y-m-d')) }}" required>
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Time In</label>
                    <input type="time" name="time_in" class="form-control @error('time_in') is-invalid @enderror" 
                           value="{{ old('time_in') }}">
                    @error('time_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time Out</label>
                    <input type="time" name="time_out" class="form-control @error('time_out') is-invalid @enderror" 
                           value="{{ old('time_out') }}">
                    @error('time_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                        <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Record</button>
        </form>
    </div>
</div>
@endsection
