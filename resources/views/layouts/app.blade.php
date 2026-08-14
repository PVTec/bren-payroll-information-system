<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nova Payroll')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #06b6d4;
            --accent: #8b5cf6;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #1e293b;
            --sidebar-active-text: #f8fafc;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #334155;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #0ea5e9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }

        .sidebar-header {
            padding: 24px;
            background: #020617;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .sidebar-header h4 {
            color: #f8fafc;
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .sidebar-header span {
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar-nav .nav-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #a8a29e;
            padding: 16px 24px 8px;
            font-weight: 700;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: 12px 24px;
            margin: 4px 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            border-radius: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-active);
            color: var(--sidebar-active-text);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .sidebar-nav .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid var(--border-color);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 0;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 32px;
            background: white;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-menu .user-info {
            text-align: right;
        }

        .user-menu .user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .user-menu .user-role {
            font-size: 0.75rem;
            color: var(--primary);
            text-transform: uppercase;
            font-weight: 600;
            background: #fff7ed;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .content-area {
            padding: 32px;
        }

        .card {
            background: var(--card-bg);
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
        }

        .card-header h5 {
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            font-size: 1rem;
        }

        .card-body {
            padding: 24px;
        }

        .stat-card {
            padding: 24px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            letter-spacing: -1px;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
        }

        .bg-gradient-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
        }

        .table {
            font-size: 0.9rem;
        }

        .table th {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            background: #fafaf9;
        }

        .table td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-secondary {
            background: #e7e5e4;
            color: #57534e;
        }

        .btn-secondary:hover {
            background: #d6d3d1;
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 0.8rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9rem;
            padding: 16px 20px;
        }

        .form-control, .form-select {
            border: 1px solid #e7e5e4;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .badge {
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        .progress {
            border-radius: 10px;
            background: #e7e5e4;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .avatar-circle {
            font-weight: 600;
        }

        .rounded-3 {
            border-radius: 12px !important;
        }

        .list-group-item {
            border-color: var(--border-color);
            padding: 16px 0;
        }

        .accordion-button:not(.collapsed) {
            background: #fff7ed;
            color: var(--sidebar-active-text);
        }

        .accordion-button:focus {
            box-shadow: none;
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="sidebar-logo">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <h4>Payroll</h4>
                        <span>Management System</span>
                    </div>
                </div>
            </div>
            <nav class="sidebar-nav flex-grow-1">
                @if(auth()->user()->isAdmin())
                    <div class="nav-section">Overview</div>
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>

                    <div class="nav-section">Workforce</div>
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        <i class="bi bi-people-fill"></i> Employees
                    </a>
                    <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                        <i class="bi bi-diagram-3"></i> Departments
                    </a>
                    <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                        <i class="bi bi-clock-history"></i> Attendance
                    </a>

                    <div class="nav-section">Compensation</div>
                    <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                        <i class="bi bi-wallet2"></i> Payroll Runs
                    </a>
                    <a class="nav-link {{ request()->routeIs('deductions.*') ? 'active' : '' }}" href="{{ route('deductions.index') }}">
                        <i class="bi bi-sliders"></i> Deduction Rules
                    </a>

                    <div class="nav-section">Analytics</div>
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-graph-up-arrow"></i> Reports
                    </a>

                    <div class="nav-section">Tools</div>
                    <a class="nav-link {{ request()->routeIs('emails.*') ? 'active' : '' }}" href="{{ route('emails.index') }}">
                        <i class="bi bi-send"></i> Email Notifications
                    </a>
                    <a class="nav-link {{ request()->routeIs('help.*') ? 'active' : '' }}" href="{{ route('help.index') }}">
                        <i class="bi bi-life-preserver"></i> Help Center
                    </a>

                    <div class="nav-section">Session</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-contents">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-power"></i> Logout
                        </button>
                    </form>
                @elseif(auth()->user()->isStaff())
                    <div class="nav-section">Overview</div>
                    <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>

                    <div class="nav-section">Workforce</div>
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        <i class="bi bi-people-fill"></i> Employees
                    </a>
                    <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                        <i class="bi bi-clock-history"></i> Attendance
                    </a>

                    <div class="nav-section">Compensation</div>
                    <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                        <i class="bi bi-wallet2"></i> Payroll
                    </a>

                    <div class="nav-section">Analytics</div>
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-graph-up-arrow"></i> Reports
                    </a>

                    <div class="nav-section">Tools</div>
                    <a class="nav-link {{ request()->routeIs('help.*') ? 'active' : '' }}" href="{{ route('help.index') }}">
                        <i class="bi bi-life-preserver"></i> Help Center
                    </a>

                    <div class="nav-section">Session</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-contents">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-power"></i> Logout
                        </button>
                    </form>
                @elseif(auth()->user()->isGuest())
                    <div class="nav-section">Support</div>
                    <a class="nav-link {{ request()->routeIs('help.employee') ? 'active' : '' }}" href="{{ route('help.employee') }}">
                        <i class="bi bi-question-circle"></i> Help & Guide
                    </a>

                    <div class="nav-section">Main</div>
                    <a class="nav-link {{ request()->routeIs('guest.dashboard') ? 'active' : '' }}" href="{{ route('guest.dashboard') }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>

                    <div class="nav-section">Directory</div>
                    <a class="nav-link {{ request()->routeIs('guest.employees') ? 'active' : '' }}" href="{{ route('guest.employees') }}">
                        <i class="bi bi-people"></i> Employees
                    </a>
                    <a class="nav-link {{ request()->routeIs('guest.payrolls') ? 'active' : '' }}" href="{{ route('guest.payrolls') }}">
                        <i class="bi bi-cash-stack"></i> Payroll Records
                    </a>
                    <a class="nav-link {{ request()->routeIs('guest.reports') ? 'active' : '' }}" href="{{ route('guest.reports') }}">
                        <i class="bi bi-file-earmark-text"></i> Reports
                    </a>

                    <div class="nav-section">Account</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-contents">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </button>
                    </form>
                @elseif(auth()->user()->isEmployee())
                    <div class="nav-section">Overview</div>
                    <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>

                    <div class="nav-section">My Records</div>
                    <a class="nav-link {{ request()->routeIs('payrolls.payslip*') ? 'active' : '' }}" href="{{ route('payrolls.employee') }}">
                        <i class="bi bi-wallet2"></i> Payslips
                    </a>
                    <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.my') }}">
                        <i class="bi bi-clock-history"></i> My Attendance
                    </a>

                    <div class="nav-section">Tools</div>
                    <a class="nav-link {{ request()->routeIs('help.employee') ? 'active' : '' }}" href="{{ route('help.employee') }}">
                        <i class="bi bi-life-preserver"></i> Help Center
                    </a>

                    <div class="nav-section">Session</div>
                    <form method="POST" action="{{ route('logout') }}" class="d-contents">
                        @csrf
                        <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                            <i class="bi bi-power"></i> Logout
                        </button>
                    </form>
                @endif
            </nav>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    @yield('page-title')
                    <h2>@yield('title', 'Dashboard')</h2>
                </div>
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    @else
        @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
