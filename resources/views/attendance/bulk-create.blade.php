@extends('layouts.app')

@section('title', 'Bulk Attendance Entry')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Bulk Attendance Entry</h2>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.bulk.store') }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control" value="{{ $today }}" required>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Status</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $emp)
                            <tr>
                                <td>
                                    <strong>{{ $emp->full_name }}</strong>
                                    <input type="hidden" name="attendance[{{ $loop->index }}][employee_id]" value="{{ $emp->id }}">
                                </td>
                                <td>
                                    <select name="attendance[{{ $loop->index }}][status]" class="form-select form-select-sm">
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="half_day">Half Day</option>
                                        <option value="leave">Leave</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="time" name="attendance[{{ $loop->index }}][time_in]" class="form-control form-control-sm" value="08:00">
                                </td>
                                <td>
                                    <input type="time" name="attendance[{{ $loop->index }}][time_out]" class="form-control form-control-sm" value="17:00">
                                </td>
                                <td>
                                    <input type="text" name="attendance[{{ $loop->index }}][remarks]" class="form-control form-control-sm">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Save All Records</button>
        </form>
    </div>
</div>
@endsection
