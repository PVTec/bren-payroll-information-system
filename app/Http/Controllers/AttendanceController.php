<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', today());
        }

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest()->paginate(25);
        $employees = Employee::where('status', 'active')->get();

        return view('attendance.index', compact('attendances', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status' => 'required|in:present,absent,late,half_day,leave',
            'remarks' => 'nullable|string',
        ]);

        $existing = Attendance::where('employee_id', $validated['employee_id'])
            ->where('date', $validated['date'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Attendance record already exists for this date');
        }

        Attendance::create($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance recorded successfully');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status' => 'required|in:present,absent,late,half_day,leave',
            'remarks' => 'nullable|string',
        ]);

        $attendance->update($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated successfully');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted');
    }

    public function bulkCreate()
    {
        $employees = Employee::where('status', 'active')->get();
        $today = today()->format('Y-m-d');

        return view('attendance.bulk-create', compact('employees', 'today'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.employee_id' => 'required|exists:employees,id',
            'attendance.*.status' => 'required|in:present,absent,late,half_day,leave',
            'attendance.*.time_in' => 'nullable',
            'attendance.*.time_out' => 'nullable',
            'attendance.*.remarks' => 'nullable|string',
        ]);

        $created = 0;
        $updated = 0;

        foreach ($validated['attendance'] as $record) {
            $existing = Attendance::where('employee_id', $record['employee_id'])
                ->where('date', $validated['date'])
                ->first();

            $data = [
                'employee_id' => $record['employee_id'],
                'date' => $validated['date'],
                'status' => $record['status'],
                'time_in' => $record['time_in'] ?? null,
                'time_out' => $record['time_out'] ?? null,
                'remarks' => $record['remarks'] ?? null,
            ];

            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                Attendance::create($data);
                $created++;
            }
        }

        return redirect()->route('attendance.index', ['date' => $validated['date']])
            ->with('success', "Attendance recorded: {$created} created, {$updated} updated");
    }

    public function report(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $query = Attendance::with('employee')
            ->whereBetween('date', [$startDate, $endDate]);

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        $attendances = $query->get();

        $summary = $attendances->groupBy('employee_id')->map(function ($records) {
            return [
                'employee' => $records->first()->employee,
                'present' => $records->where('status', 'present')->count(),
                'absent' => $records->where('status', 'absent')->count(),
                'late' => $records->where('status', 'late')->count(),
                'half_day' => $records->where('status', 'half_day')->count(),
                'leave' => $records->where('status', 'leave')->count(),
                'total_hours' => $records->sum('hours_worked'),
            ];
        });

        $employees = Employee::where('status', 'active')->get();

        return view('attendance.report', compact('attendances', 'summary', 'employees', 'startDate', 'endDate'));
    }

    public function myAttendance()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee record not found');
        }

        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('attendance.my', compact('attendances'));
    }
}
