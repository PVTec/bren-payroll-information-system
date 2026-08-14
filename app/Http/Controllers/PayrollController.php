<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Services\PayrollCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('employee');

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('period') && $request->period) {
            $query->where('payroll_period', $request->period);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $payrolls = $query->latest()->paginate(15);
        $employees = Employee::where('status', 'active')->get();
        $periods = Payroll::distinct()->pluck('payroll_period');

        return view('payrolls.index', compact('payrolls', 'employees', 'periods'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payroll_period' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payroll_type' => 'required|in:monthly,weekly,semi_monthly',
        ]);

        $existing = Payroll::where('employee_id', $validated['employee_id'])
            ->where('payroll_period', $validated['payroll_period'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Payroll already exists for this employee and period');
        }

        $payroll = Payroll::create([
            'employee_id' => $validated['employee_id'],
            'payroll_period' => $validated['payroll_period'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'payroll_type' => $validated['payroll_type'],
            'basic_pay' => 0,
            'gross_pay' => 0,
            'total_deductions' => 0,
            'net_pay' => 0,
            'status' => 'draft',
        ]);

        $this->processPayroll($payroll);

        return redirect()->route('payrolls.show', $payroll)
            ->with('success', 'Payroll created and calculated successfully');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('employee', 'items', 'processor');
        return view('payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        if (!$payroll->isDraft()) {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Cannot edit processed payroll');
        }

        $payroll->load('employee', 'items');
        return view('payrolls.edit', compact('payroll'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        if (!$payroll->isDraft()) {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Cannot update processed payroll');
        }

        $validated = $request->validate([
            'basic_pay' => 'nullable|numeric|min:0',
        ]);

        $payroll->update($validated);
        $this->processPayroll($payroll);

        return redirect()->route('payrolls.show', $payroll)
            ->with('success', 'Payroll updated successfully');
    }

    public function process(Payroll $payroll)
    {
        if (!$payroll->isDraft()) {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Payroll is already processed');
        }

        $payroll->markAsProcessed(Auth::id());

        return redirect()->route('payrolls.show', $payroll)
            ->with('success', 'Payroll processed successfully');
    }

    public function bulkCreate()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payrolls.bulk-create', compact('employees'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'payroll_period' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payroll_type' => 'required|in:monthly,weekly,semi_monthly',
        ]);

        $created = 0;
        $skipped = 0;

        foreach ($validated['employee_ids'] as $employeeId) {
            $existing = Payroll::where('employee_id', $employeeId)
                ->where('payroll_period', $validated['payroll_period'])
                ->first();

            if ($existing) {
                $skipped++;
                continue;
            }

            $payroll = Payroll::create([
                'employee_id' => $employeeId,
                'payroll_period' => $validated['payroll_period'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'payroll_type' => $validated['payroll_type'],
                'basic_pay' => 0,
                'gross_pay' => 0,
                'total_deductions' => 0,
                'net_pay' => 0,
                'status' => 'draft',
            ]);

            $this->processPayroll($payroll);
            $created++;
        }

        $message = "Created {$created} payrolls";
        if ($skipped > 0) {
            $message .= ", skipped {$skipped} (already exist)";
        }

        return redirect()->route('payrolls.index')
            ->with('success', $message);
    }

    public function addItem(Request $request, Payroll $payroll)
    {
        if (!$payroll->isDraft()) {
            return back()->with('error', 'Cannot modify processed payroll');
        }

        $validated = $request->validate([
            'type' => 'required|in:earning,deduction',
            'category' => 'required|string',
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $payroll->items()->create($validated);
        $this->recalculatePayroll($payroll);

        return back()->with('success', 'Item added successfully');
    }

    public function removeItem(Payroll $payroll, PayrollItem $item)
    {
        if (!$payroll->isDraft()) {
            return back()->with('error', 'Cannot modify processed payroll');
        }

        $item->delete();
        $this->recalculatePayroll($payroll);

        return back()->with('success', 'Item removed successfully');
    }

    public function payslip(Payroll $payroll)
    {
        $payroll->load('employee.department', 'items');
        return view('payrolls.payslip', compact('payroll'));
    }

    private function processPayroll(Payroll $payroll)
    {
        $calculator = new PayrollCalculator($payroll);
        $result = $calculator->calculate();

        $payroll->update([
            'basic_pay' => $result['basic_pay'],
            'gross_pay' => $result['gross_pay'],
            'total_deductions' => $result['total_deductions'],
            'net_pay' => $result['net_pay'],
        ]);

        $payroll->items()->delete();

        foreach ($result['earnings'] as $earning) {
            $payroll->items()->create(array_merge($earning, ['type' => 'earning']));
        }

        foreach ($result['deductions'] as $deduction) {
            $payroll->items()->create(array_merge($deduction, ['type' => 'deduction']));
        }
    }

    private function recalculatePayroll(Payroll $payroll)
    {
        $grossPay = $payroll->earnings()->sum('amount');
        $totalDeductions = $payroll->deductions()->sum('amount');
        $netPay = $grossPay - $totalDeductions;

        $payroll->update([
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
        ]);
    }

    public function employeePayrolls()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee record not found');
        }

        $payrolls = Payroll::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payrolls.employee', compact('payrolls'));
    }
}
