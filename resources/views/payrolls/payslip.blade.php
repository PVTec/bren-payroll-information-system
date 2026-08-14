<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payslip - {{ $payroll->employee->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .employee-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .info-section {
            width: 48%;
        }
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .summary-row.total {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        .net-pay {
            color: #27ae60;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
        }
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button onclick="window.print()">Print Payslip</button>
            <button onclick="window.close()">Close</button>
        </div>

        <div class="header">
            <h1>PAYSLIP</h1>
            <p>{{ $payroll->employee->department->name ?? 'Company Name' }}</p>
            <p>Payroll Period: {{ $payroll->payroll_period }}</p>
        </div>

        <div class="employee-info">
            <div class="info-section">
                <h3>Employee Information</h3>
                <div class="info-row">
                    <span class="info-label">Employee Name:</span>
                    <span>{{ $payroll->employee->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Employee ID:</span>
                    <span>{{ $payroll->employee->employee_id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Position:</span>
                    <span>{{ $payroll->employee->position }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Department:</span>
                    <span>{{ $payroll->employee->department->name ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="info-section">
                <h3>Payroll Details</h3>
                <div class="info-row">
                    <span class="info-label">Pay Period:</span>
                    <span>{{ $payroll->payroll_period }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date Range:</span>
                    <span>{{ $payroll->start_date->format('M d, Y') }} - {{ $payroll->end_date->format('M d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payroll Type:</span>
                    <span>{{ ucfirst($payroll->payroll_type) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span>{{ ucfirst($payroll->status) }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 20px;">
            <div style="width: 50%;">
                <h3>Earnings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payroll->earnings as $earning)
                            <tr>
                                <td>{{ $earning->name }}</td>
                                <td class="text-right">₱{{ number_format($earning->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="width: 50%;">
                <h3>Deductions</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payroll->deductions as $deduction)
                            <tr>
                                <td>{{ $deduction->name }}</td>
                                <td class="text-right">₱{{ number_format($deduction->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="summary">
            <div class="summary-row">
                <span>Total Earnings (Gross Pay):</span>
                <span>₱{{ number_format($payroll->gross_pay, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Total Deductions:</span>
                <span>₱{{ number_format($payroll->total_deductions, 2) }}</span>
            </div>
            <div class="summary-row total">
                <span class="net-pay">NET PAY:</span>
                <span class="net-pay">₱{{ number_format($payroll->net_pay, 2) }}</span>
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Employee Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Authorized By</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Date Received</div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
            <p>This is a computer-generated payslip and does not require a physical signature.</p>
            <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>
