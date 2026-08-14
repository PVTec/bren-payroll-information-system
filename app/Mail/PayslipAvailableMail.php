<?php

namespace App\Mail;

use App\Models\Payroll;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayslipAvailableMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $payroll;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Payslip is Available - ' . $this->payroll->payroll_period,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payslip-available',
            with: [
                'payroll' => $this->payroll,
                'employee' => $this->payroll->employee,
                'payslipUrl' => route('payrolls.payslip', $this->payroll),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
