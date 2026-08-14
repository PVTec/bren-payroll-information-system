@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        padding: 20px;
    }
    .login-wrapper {
        display: flex;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        width: 100%;
        max-width: 900px;
        min-height: 500px;
    }
    .login-info {
        background: #0f172a;
        padding: 48px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
    }
    .login-info .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
    }
    .login-info .logo i {
        font-size: 2rem;
        color: #3b82f6;
    }
    .login-info .logo h3 {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
    }
    .login-info h2 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 16px;
        line-height: 1.3;
    }
    .login-info p {
        color: #94a3b8;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 32px;
    }
    .login-info .features {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .login-info .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #e2e8f0;
        font-size: 0.9rem;
    }
    .login-info .feature-item i {
        color: #3b82f6;
        font-size: 1.1rem;
    }
    .login-box {
        padding: 48px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .login-box h4 {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 8px;
        color: #0f172a;
    }
    .login-box .subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 32px;
    }
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: white;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-label {
        font-weight: 500;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 6px;
    }
    .btn-login {
        background: #0f172a;
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        margin-top: 8px;
    }
    .btn-login:hover {
        background: #1e293b;
    }
    .sample-accounts {
        margin-top: 24px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .sample-accounts h6 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .account-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: white;
        border-radius: 6px;
        margin-bottom: 6px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.15s ease;
        font-size: 0.85rem;
    }
    .account-item:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    .account-item:last-child {
        margin-bottom: 0;
    }
    .account-role {
        font-size: 0.7rem;
        color: #3b82f6;
        font-weight: 600;
        text-transform: uppercase;
        background: #dbeafe;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .account-creds {
        font-size: 0.8rem;
        color: #64748b;
    }
    .alert-danger {
        border-radius: 8px;
        border: none;
        background: #fef2f2;
        color: #dc2626;
        padding: 12px 16px;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
        }
        .login-info {
            padding: 32px;
        }
        .login-box {
            padding: 32px;
        }
    }
</style>

<div class="login-container">
    <div class="login-wrapper">
        <div class="login-info">
            <div class="logo">
                <i class="bi bi-cash-stack"></i>
                <h3>Payroll</h3>
            </div>
            <h2>Payroll<br>Management System</h2>
            <p>A comprehensive solution for managing employee records, processing payroll, tracking attendance, and generating reports. Streamline your HR operations.</p>
            <div class="features">
                <div class="feature-item">
                    <i class="bi bi-people"></i>
                    <span>Employee Management</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-cash-coin"></i>
                    <span>Automated Payroll Processing</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-calendar-check"></i>
                    <span>Attendance Tracking</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Reports & Analytics</span>
                </div>
            </div>
        </div>
        <div class="login-box">
            <h4>Welcome back</h4>
            <p class="subtitle">Sign in to access your account</p>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="name@company.com" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" 
                           id="password" name="password" 
                           placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-login text-white w-100">
                    Sign In
                </button>
            </form>

            <div class="sample-accounts">
                <h6>Demo Accounts</h6>
                <div class="account-item" onclick="fillLogin('admin@payroll.com', 'password123')">
                    <span class="account-role">Admin</span>
                    <span class="account-creds">password123</span>
                </div>
                <div class="account-item" onclick="fillLogin('staff@payroll.com', 'password123')">
                    <span class="account-role">Staff</span>
                    <span class="account-creds">password123</span>
                </div>
                <div class="account-item" onclick="fillLogin('employee@payroll.com', 'password123')">
                    <span class="account-role">Employee</span>
                    <span class="account-creds">password123</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillLogin(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
    document.getElementById('loginForm').submit();
}
</script>
@endsection
