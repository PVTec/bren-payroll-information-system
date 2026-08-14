<?php

namespace App\Http\Controllers;

use App\Mail\PayrollProcessedMail;
use App\Mail\PayslipAvailableMail;
use App\Models\EmailLog;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailLog::with('mailable');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('recipient_email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $emails = $query->latest()->paginate(20);
        $stats = [
            'total' => EmailLog::count(),
            'sent' => EmailLog::sent()->count(),
            'pending' => EmailLog::pending()->count(),
            'failed' => EmailLog::failed()->count(),
        ];

        return view('emails.index', compact('emails', 'stats'));
    }

    public function compose()
    {
        $employees = Employee::where('status', 'active')->get();
        $templates = [
            'payroll_processed' => 'Payroll Processed Notification',
            'payslip_available' => 'Payslip Available Notification',
            'custom' => 'Custom Message',
        ];

        return view('emails.compose', compact('employees', 'templates'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'recipients' => 'required|array',
            'recipients.*' => 'exists:employees,id',
            'template' => 'required|string',
            'subject' => 'required_if:template,custom|string|nullable',
            'message' => 'required_if:template,custom|string|nullable',
        ]);

        $sent = 0;
        $failed = 0;

        foreach ($validated['recipients'] as $employeeId) {
            $employee = Employee::find($employeeId);

            if (!$employee || !$employee->user) {
                $failed++;
                continue;
            }

            try {
                if ($validated['template'] === 'custom') {
                    $this->sendCustomEmail($employee, $validated['subject'], $validated['message']);
                } else {
                    $this->sendTemplateEmail($employee, $validated['template']);
                }
                $sent++;
            } catch (\Exception $e) {
                $failed++;
            }
        }

        $message = "Sent {$sent} emails";
        if ($failed > 0) {
            $message .= ", {$failed} failed";
        }

        return redirect()->route('emails.index')->with('success', $message);
    }

    public function sendPayrollNotification(Payroll $payroll)
    {
        try {
            $emailLog = EmailLog::create([
                'recipient_email' => $payroll->employee->user->email,
                'recipient_name' => $payroll->employee->full_name,
                'subject' => 'Your Payroll Has Been Processed - ' . $payroll->payroll_period,
                'template' => 'payroll_processed',
                'mailable_type' => Payroll::class,
                'mailable_id' => $payroll->id,
                'status' => 'pending',
            ]);

            Mail::to($payroll->employee->user->email)
                ->send(new PayrollProcessedMail($payroll));

            $emailLog->markAsSent();

            return back()->with('success', 'Payroll notification email sent successfully');
        } catch (\Exception $e) {
            if (isset($emailLog)) {
                $emailLog->markAsFailed($e->getMessage());
            }
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function sendPayslipNotification(Payroll $payroll)
    {
        try {
            $emailLog = EmailLog::create([
                'recipient_email' => $payroll->employee->user->email,
                'recipient_name' => $payroll->employee->full_name,
                'subject' => 'Your Payslip is Available - ' . $payroll->payroll_period,
                'template' => 'payslip_available',
                'mailable_type' => Payroll::class,
                'mailable_id' => $payroll->id,
                'status' => 'pending',
            ]);

            Mail::to($payroll->employee->user->email)
                ->send(new PayslipAvailableMail($payroll));

            $emailLog->markAsSent();

            return back()->with('success', 'Payslip notification email sent successfully');
        } catch (\Exception $e) {
            if (isset($emailLog)) {
                $emailLog->markAsFailed($e->getMessage());
            }
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function show(EmailLog $email)
    {
        return view('emails.show', compact('email'));
    }

    public function retry(EmailLog $email)
    {
        if ($email->status !== 'failed') {
            return back()->with('error', 'Only failed emails can be retried');
        }

        try {
            $email->update(['status' => 'pending', 'error_message' => null]);

            if ($email->template === 'payroll_processed' && $email->mailable) {
                Mail::to($email->recipient_email)
                    ->send(new PayrollProcessedMail($email->mailable));
            } elseif ($email->template === 'payslip_available' && $email->mailable) {
                Mail::to($email->recipient_email)
                    ->send(new PayslipAvailableMail($email->mailable));
            }

            $email->markAsSent();
            return back()->with('success', 'Email resent successfully');
        } catch (\Exception $e) {
            $email->markAsFailed($e->getMessage());
            return back()->with('error', 'Failed to resend email: ' . $e->getMessage());
        }
    }

    private function sendCustomEmail($employee, $subject, $message)
    {
        $emailLog = EmailLog::create([
            'recipient_email' => $employee->user->email,
            'recipient_name' => $employee->full_name,
            'subject' => $subject,
            'body' => $message,
            'template' => 'custom',
            'mailable_type' => Employee::class,
            'mailable_id' => $employee->id,
            'status' => 'pending',
        ]);

        Mail::raw($message, function($mail) use ($employee, $subject) {
            $mail->to($employee->user->email, $employee->full_name)
                 ->subject($subject);
        });

        $emailLog->markAsSent();
    }

    private function sendTemplateEmail($employee, $template)
    {
        $latestPayroll = Payroll::where('employee_id', $employee->id)
            ->where('status', 'processed')
            ->latest()
            ->first();

        if (!$latestPayroll) {
            throw new \Exception('No processed payroll found for employee');
        }

        if ($template === 'payroll_processed') {
            $this->sendPayrollNotification($latestPayroll);
        } elseif ($template === 'payslip_available') {
            $this->sendPayslipNotification($latestPayroll);
        }
    }
}
