<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip Available</title>
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
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
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
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
        }
        .btn {
            display: inline-block;
            background: #10b981;
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
            <h1>Your Payslip is Available</h1>
        </div>
        <div class="content">
            <p>Hi {{ $employee->first_name }},</p>
            <p>Your payslip for <strong>{{ $payroll->payroll_period }}</strong> is now available for viewing and download.</p>

            <div class="info-box">
                <strong>Pay Period:</strong> {{ $payroll->payroll_period }}<br>
                <strong>Net Pay:</strong> ₱{{ number_format($payroll->net_pay, 2) }}<br>
                <strong>Available Since:</strong> {{ now()->format('M d, Y') }}
            </div>

            <p>You can view your detailed payslip by clicking the button below:</p>

            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ $payslipUrl }}" class="btn">View My Payslip</a>
            </p>

            <p style="font-size: 13px; color: #64748b;">
                <strong>Note:</strong> Please keep your payslip information confidential. If you notice any discrepancies, please contact your HR department immediately.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated message from the Bren Payroll Information System.</p>
            <p>&copy; {{ date('Y') }} Bren Payroll Information System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
