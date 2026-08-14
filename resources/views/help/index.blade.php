@extends('layouts.app')

@section('title', 'Help & Guide')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-purple text-white">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mb-1">Bren Payroll System Documentation</h4>
                        <p class="mb-0 opacity-75">Comprehensive guide for administrators, staff, employees, and guests</p>
                    </div>
                    <div class="flex-shrink-0 ms-4">
                        <i class="bi bi-book fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-stars me-2 text-warning"></i>System Features Overview</h5>
            </div>
            <div class="card-body">
                <p>The <strong>Bren Payroll Information System</strong> is a comprehensive solution for managing HR operations, payroll processing, and employee communications.</p>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Admin Management</h6>
                                <p class="small text-muted mb-0">Full system control, user management, and configuration settings</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 me-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Employee Records</h6>
                                <p class="small text-muted mb-0">Complete employee database with profiles and history</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-info bg-opacity-10 text-info rounded-3 me-3">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Payroll Records</h6>
                                <p class="small text-muted mb-0">Process and manage payroll with auto-calculated deductions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 me-3">
                                <i class="bi bi-calendar-range"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Payroll Periods</h6>
                                <p class="small text-muted mb-0">Flexible payroll scheduling and period management</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-purple bg-opacity-10 text-primary rounded-3 me-3" style="background: rgba(139,92,246,0.1) !important; color: #8b5cf6 !important;">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Payslips</h6>
                                <p class="small text-muted mb-0">Digital payslip generation and distribution</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-3 me-3">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Salary Components</h6>
                                <p class="small text-muted mb-0">Manage earnings, deductions, and benefits</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-secondary bg-opacity-10 text-secondary rounded-3 me-3">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email System</h6>
                                <p class="small text-muted mb-0">Send payroll notifications and custom emails</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="stat-icon bg-dark bg-opacity-10 text-dark rounded-3 me-3">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Guest Access</h6>
                                <p class="small text-muted mb-0">View-only access for auditors and visitors</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-question-circle me-2 text-primary"></i>Frequently Asked Questions</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I add a new employee?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Navigate to <strong>People > Employees</strong> and click "Add New Employee". Complete all required fields including personal details, employment information, and government ID numbers. The system automatically creates a login account for the employee.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How do I send email notifications?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Go to <strong>Communications > Email Center</strong>. You can compose custom messages or use templates for payroll notifications and payslip alerts. Select recipients from the employee list and send.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What is Guest access?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Guest users have <strong>view-only access</strong> to employee directories, payroll records, and reports. This role is ideal for auditors, trainees, or stakeholders who need visibility without editing permissions.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How do I process payroll with automatic deductions?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Go to <strong>Payroll</strong> and click "Create New Payroll" or "Bulk Payroll". The system automatically calculates SSS, PhilHealth, Pag-IBIG, and withholding tax based on government tables.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                How do I record attendance?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Navigate to <strong>Payroll > Attendance</strong>. Use individual entry or "Bulk Entry" for multiple employees. Enter time in/out and the system calculates hours automatically.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                What are the different user roles?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong class="text-primary">Admin</strong> - Full system access, configuration, and user management</li>
                                    <li class="mb-2"><strong class="text-success">Staff</strong> - Process payroll, manage employees, view reports</li>
                                    <li class="mb-2"><strong class="text-info">Employee</strong> - View personal dashboard, payslips, and records</li>
                                    <li><strong class="text-secondary">Guest</strong> - View-only access to directory and reports</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-lightbulb me-2 text-warning"></i>Best Practices</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">For Administrators</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Regularly backup your database
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Review deduction settings annually
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Use bulk operations to save time
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Monitor email delivery status
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">For Payroll Officers</h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Process payroll before the 15th/30th
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Send email notifications to employees
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Verify attendance before finalizing
                            </div>
                            <div class="list-group-item px-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>Double-check government ID numbers
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-info"></i>System Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">System Name</td>
                        <td class="fw-medium">Bren Payroll IS</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Version</td>
                        <td class="fw-medium">2.0.0</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Release Date</td>
                        <td class="fw-medium">April 2025</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Updated</td>
                        <td class="fw-medium">{{ now()->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Support</td>
                        <td class="fw-medium">support@brenpayroll.com</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-envelope me-2 text-primary"></i>Contact Support</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Need assistance? Our support team is here to help.</p>
                <a href="mailto:support@brenpayroll.com" class="btn btn-primary w-100">
                    <i class="bi bi-envelope me-2"></i>Email Support
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-journal-bookmark me-2 text-success"></i>Quick Links</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action px-0 py-2">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>User Manual PDF
                    </a>
                    <a href="#" class="list-group-item list-group-item-action px-0 py-2">
                        <i class="bi bi-play-circle text-primary me-2"></i>Video Tutorials
                    </a>
                    <a href="#" class="list-group-item list-group-item-action px-0 py-2">
                        <i class="bi bi-shield text-success me-2"></i>Security Guidelines
                    </a>
                    <a href="#" class="list-group-item list-group-item-action px-0 py-2">
                        <i class="bi bi-code-square text-info me-2"></i>API Documentation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
