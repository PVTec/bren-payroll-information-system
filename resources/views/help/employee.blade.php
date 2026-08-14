@extends('layouts.app')

@section('title', 'Employee Help & Guide')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-info text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-1">Employee Help Center</h4>
                        <p class="mb-0 opacity-75">Your guide to using the Bren Payroll Information System</p>
                    </div>
                    <div class="flex-shrink-0 ms-4">
                        <i class="bi bi-person-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-question-circle me-2 text-primary"></i>Frequently Asked Questions</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="employeeFaq">
                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I view my payslip?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                Navigate to your <strong>Dashboard</strong> and find the "Recent Payrolls" section. Click on any payroll period to view your detailed payslip with complete breakdown of earnings and deductions. You can also print or save your payslip as PDF.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Will I receive email notifications for my payroll?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                <strong>Yes!</strong> The Bren Payroll System automatically sends email notifications when your payroll is processed and when your payslip is available. Make sure your email address is up to date in your profile.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What information can I see on my dashboard?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                Your personal dashboard displays:<br>
                                <i class="bi bi-check text-success me-1"></i>Basic employee information (ID, department, position)<br>
                                <i class="bi bi-check text-success me-1"></i>Recent payroll records with gross pay, deductions, and net pay<br>
                                <i class="bi bi-check text-success me-1"></i>Attendance summary for the current period<br>
                                <i class="bi bi-check text-success me-1"></i>Quick access to your latest payslip
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How are my deductions calculated?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                Your monthly deductions include mandatory government contributions:
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary me-2">SSS</span>
                                            <small>Social Security System</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-success me-2">PhilHealth</span>
                                            <small>Health insurance</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info me-2">Pag-IBIG</span>
                                            <small>Housing fund</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning me-2">Tax</span>
                                            <small>Withholding tax</small>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">All calculations follow current government regulations.</small>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                When will I receive my salary?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                Standard paydays are on the <strong>15th and 30th</strong> of each month. If these dates fall on weekends or holidays, payment will be processed on the nearest business day. You will receive an email notification once your payroll is processed.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                What should I do if my payroll information is incorrect?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                If you notice any discrepancies (wrong salary, missing deductions, incorrect attendance), contact your <strong>HR department</strong> immediately. Provide specific details about the issue including the payroll period and expected corrections.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                How do I update my account information?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#employeeFaq">
                            <div class="accordion-body">
                                Contact your HR department to update your email address, contact information, or other account details. They will make the necessary changes to ensure your records are accurate.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-lightbulb me-2 text-warning"></i>Quick Tips</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>Check your dashboard weekly for updates
                    </li>
                    <li class="list-group-item px-0">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>Save digital copies of your payslips
                    </li>
                    <li class="list-group-item px-0">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>Verify your attendance records monthly
                    </li>
                    <li class="list-group-item px-0">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>Report discrepancies within 3 days
                    </li>
                    <li class="list-group-item px-0">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>Watch for email notifications
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-info"></i>System Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 me-3">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Secure & Confidential</h6>
                        <small class="text-muted">All payroll data is encrypted and protected</small>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    The Bren Payroll Information System provides you with secure, 24/7 access to your payroll records, payslips, and employment information. All access is logged for security purposes.
                </p>
                <hr>
                <div class="text-center">
                    <small class="text-muted">Version 2.0.0 | Released April 2025</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-headset me-2 text-success"></i>Contact Support</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">HR Department</h6>
                                <small class="text-muted">Payroll discrepancies</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 me-3">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Payroll Officer</h6>
                                <small class="text-muted">Salary & deduction questions</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 me-3">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">IT Support</h6>
                                <small class="text-muted">Login & technical issues</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
