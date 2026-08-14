<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payroll Management System</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
:root { --primary: #f59e0b; --primary-dark: #d97706; --primary-light: #fbbf24; --secondary: #0ea5e9; --dark: #1e293b; --light: #f8fafc; }
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: "Instrument Sans", system-ui, sans-serif; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 50%, #fed7aa 100%); min-height: 100vh; }
.hero-section { min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; }
.hero-bg-pattern { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: radial-gradient(circle at 20% 50%, rgba(245, 158, 11, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(14, 165, 233, 0.08) 0%, transparent 50%), radial-gradient(circle at 40% 80%, rgba(245, 158, 11, 0.05) 0%, transparent 40%); pointer-events: none; }
.floating-shapes { position: absolute; width: 100%; height: 100%; overflow: hidden; pointer-events: none; }
.shape { position: absolute; border-radius: 50%; opacity: 0.1; }
.shape-1 { width: 300px; height: 300px; background: var(--primary); top: -100px; right: -50px; }
.shape-2 { width: 200px; height: 200px; background: var(--secondary); bottom: 10%; left: -50px; }
.shape-3 { width: 150px; height: 150px; background: var(--primary-light); top: 40%; right: 10%; }
.hero-content { position: relative; z-index: 2; }
.brand-logo { display: inline-flex; align-items: center; gap: 12px; font-size: 1.75rem; font-weight: 700; color: var(--dark); margin-bottom: 2rem; }
.brand-logo i { width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; }
.hero-title { font-size: 3.5rem; font-weight: 700; line-height: 1.1; color: var(--dark); margin-bottom: 1.5rem; }
.hero-title span { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.hero-subtitle { font-size: 1.25rem; color: #64748b; margin-bottom: 2rem; max-width: 500px; }
.btn-hero { display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; }
.btn-hero-primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3); }
.btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(245, 158, 11, 0.4); color: white; }
.feature-cards { position: relative; z-index: 2; }
.feature-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%; border: 1px solid #f1f5f9; }
.feature-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
.feature-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.25rem; }
.feature-icon.purple { background: #f3e8ff; color: #9333ea; }
.feature-icon.blue { background: #dbeafe; color: #2563eb; }
.feature-icon.green { background: #dcfce7; color: #16a34a; }
.feature-icon.amber { background: #fef3c7; color: #d97706; }
.feature-title { font-weight: 600; font-size: 1.1rem; color: var(--dark); margin-bottom: 0.5rem; }
.feature-desc { color: #64748b; font-size: 0.95rem; margin: 0; }
.stats-bar { background: white; border-radius: 16px; padding: 2rem; margin-top: 3rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; justify-content: space-around; flex-wrap: wrap; gap: 2rem; }
.stat-item { text-align: center; }
.stat-number { font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.stat-label { color: #64748b; font-size: 0.9rem; }
@media (max-width: 991px) { .hero-title { font-size: 2.5rem; } .stats-bar { flex-direction: column; gap: 1rem; } }
</style>
</head>
<body>
<section class="hero-section">
<div class="hero-bg-pattern"></div>
<div class="floating-shapes">
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>
</div>
<div class="container">
<div class="row align-items-center">
<div class="col-lg-6 hero-content">
<div class="brand-logo">
<i class="bi bi-cash-stack"></i>
<span>Payroll</span>
</div>
<h1 class="hero-title">Modern Payroll <span>Management</span> System</h1>
<p class="hero-subtitle">Streamline your payroll process with our comprehensive solution. Manage employees, process payroll, generate payslips, and send email notifications.</p>
@if (Route::has("login"))
<div class="d-flex flex-wrap gap-3">
@auth
<a href="{{ url("/dashboard") }}" class="btn-hero btn-hero-primary"><i class="bi bi-grid"></i> Go to Dashboard</a>
@else
<a href="{{ route("login") }}" class="btn-hero btn-hero-primary"><i class="bi bi-box-arrow-in-right"></i> Sign In</a>
@endauth
</div>
@endif
</div>
<div class="col-lg-6 feature-cards mt-5 mt-lg-0">
<div class="row g-4">
<div class="col-6"><div class="feature-card"><div class="feature-icon purple"><i class="bi bi-people"></i></div><h5 class="feature-title">Employees</h5><p class="feature-desc">Manage staff records</p></div></div>
<div class="col-6"><div class="feature-card"><div class="feature-icon amber"><i class="bi bi-cash-coin"></i></div><h5 class="feature-title">Payroll</h5><p class="feature-desc">Process salaries</p></div></div>
<div class="col-6"><div class="feature-card"><div class="feature-icon blue"><i class="bi bi-envelope"></i></div><h5 class="feature-title">Email</h5><p class="feature-desc">Send notifications</p></div></div>
<div class="col-6"><div class="feature-card"><div class="feature-icon green"><i class="bi bi-graph-up"></i></div><h5 class="feature-title">Reports</h5><p class="feature-desc">View analytics</p></div></div>
</div>
<div class="stats-bar">
<div class="stat-item"><div class="stat-number">4</div><div class="stat-label">User Roles</div></div>
<div class="stat-item"><div class="stat-number">100%</div><div class="stat-label">Secure</div></div>
<div class="stat-item"><div class="stat-number">24/7</div><div class="stat-label">Support</div></div>
</div>
</div>
</div>
</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>