@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Attendance Record</h2>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.update', $attendance) }}">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Employee</label>
                    <input type="text" class="form-control" value="{{ $attendance->employee->full_name }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control" value="{{ $attendance->date->format('F d, Y') }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Time In</label>
                    <input type="time" name="time_in" class="form-control" 
                           value="{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i') : '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time Out</label>
                    <input type="time" name="time_out" class="form-control" 
                           value="{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>Half Day</option>
                        <option value="leave" {{ $attendance->status == 'leave' ? 'selected' : '' }}>Leave</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" rows="2">{{ $attendance->remarks }}</textarea>
            </div>

            <div class="alert alert-info">
                Hours worked: <strong>{{ $attendance->hours_worked }}</strong>
            </div>

            <button type="submit" class="btn btn-primary">Update Record</button>
        </form>
    </div>
</div>
@endsection
