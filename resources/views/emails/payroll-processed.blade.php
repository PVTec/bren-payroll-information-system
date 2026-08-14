<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Processed</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .payroll-info {
            background: #f8fafc;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .payroll-info table {
            width: 100%;
        }
        .payroll-info td {
            padding: 8px 0;
        }
        .payroll-info td:first-child {
            color: #64748b;
        }
        .payroll-info td:last-child {
            text-align: right;
            font-weight: 600;
        }
        .amount {
            font-size: 28px;
            color: #6366f1;
            font-weight: 700;
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background: #6366f1;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Payroll Has Been Processed</h1>
        </div>
        <div class="content">
            <p>Hi {{ $employee->first_name }},</p>
            <p>Good news! Your payroll for <strong>{{ $payroll->payroll_period }}</strong> has been processed successfully.</p>

            <div class="amount">
                Net Pay: ₱{{ number_format($payroll->net_pay, 2) }}
            </div>

            <div class="payroll-info">
                <table>
                    <tr>
                        <td>Payroll Period</td>
                        <td>{{ $payroll->payroll_period }}</td>
                    </tr>
                    <tr>
                        <td>Pay Date</td>
                        <td>{{ $payroll->end_date->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td>Gross Pay</td>
                        <td>₱{{ number_format($payroll->gross_pay, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Total Deductions</td>
                        <td>₱{{ number_format($payroll->total_deductions, 2) }}</td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('payrolls.payslip', $payroll) }}" class="btn">View Payslip</a>
            </p>

            <p style="font-size: 12px; color: #64748b; margin-top: 30px;">
                This is an automated message from the Bren Payroll Information System. Please do not reply to this email.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bren Payroll Information System. All rights reserved.
        </div>
    </div>
</body>
</html>
