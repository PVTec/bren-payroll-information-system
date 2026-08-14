<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DeductionSettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GuestController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard')
        ->middleware('role:admin');

    Route::get('/staff/dashboard', [DashboardController::class, 'staff'])
        ->name('staff.dashboard')
        ->middleware('role:admin,staff');

    Route::get('/employee/dashboard', [DashboardController::class, 'employee'])
        ->name('employee.dashboard')
        ->middleware('role:admin,staff,employee');

    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('payrolls', PayrollController::class);

        Route::get('/payrolls/bulk/create', [PayrollController::class, 'bulkCreate'])->name('payrolls.bulk.create');
        Route::post('/payrolls/bulk', [PayrollController::class, 'bulkStore'])->name('payrolls.bulk.store');
        Route::post('/payrolls/{payroll}/process', [PayrollController::class, 'process'])->name('payrolls.process');
        Route::get('/payrolls/{payroll}/payslip', [PayrollController::class, 'payslip'])->name('payrolls.payslip');
        Route::post('/payrolls/{payroll}/items', [PayrollController::class, 'addItem'])->name('payrolls.items.add');
        Route::delete('/payrolls/{payroll}/items/{item}', [PayrollController::class, 'removeItem'])->name('payrolls.items.remove');

        Route::resource('attendance', AttendanceController::class);
        Route::get('/attendance/bulk/create', [AttendanceController::class, 'bulkCreate'])->name('attendance.bulk.create');
        Route::post('/attendance/bulk', [AttendanceController::class, 'bulkStore'])->name('attendance.bulk.store');
        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

        Route::resource('deductions', DeductionSettingController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/payroll-summary', [ReportController::class, 'payrollSummary'])->name('reports.payroll-summary');
        Route::get('/reports/employee-salary', [ReportController::class, 'employeeSalary'])->name('reports.employee-salary');
        Route::get('/reports/department-summary', [ReportController::class, 'departmentSummary'])->name('reports.department-summary');
        Route::get('/reports/payroll-history', [ReportController::class, 'payrollHistory'])->name('reports.payroll-history');

        Route::get('/help', [HelpController::class, 'index'])->name('help.index');

        Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
        Route::get('/emails/compose', [EmailController::class, 'compose'])->name('emails.compose');
        Route::post('/emails/send', [EmailController::class, 'send'])->name('emails.send');
        Route::get('/emails/{email}', [EmailController::class, 'show'])->name('emails.show');
        Route::post('/emails/{email}/retry', [EmailController::class, 'retry'])->name('emails.retry');
        Route::post('/payrolls/{payroll}/notify', [EmailController::class, 'sendPayrollNotification'])->name('payrolls.notify');
        Route::post('/payrolls/{payroll}/payslip-notify', [EmailController::class, 'sendPayslipNotification'])->name('payrolls.payslip-notify');
    });

    Route::get('/help/employee', [HelpController::class, 'employee'])->name('help.employee');

    Route::middleware('role:employee')->group(function () {
        Route::get('/my/payrolls', [PayrollController::class, 'employeePayrolls'])->name('payrolls.employee');
        Route::get('/my/attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.my');
    });

    Route::middleware('role:guest')->group(function () {
        Route::get('/guest/dashboard', [GuestController::class, 'dashboard'])->name('guest.dashboard');
        Route::get('/guest/employees', [GuestController::class, 'employees'])->name('guest.employees');
        Route::get('/guest/payrolls', [GuestController::class, 'payrolls'])->name('guest.payrolls');
        Route::get('/guest/reports', [GuestController::class, 'reports'])->name('guest.reports');
    });
});
