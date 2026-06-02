<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Teacher Excellence Awards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #1a237e; --primary-light: #3949ab; --accent: #ffd700; }
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100;
            background: linear-gradient(180deg, var(--primary) 0%, #283593 100%);
            box-shadow: 2px 0 12px rgba(0,0,0,.15);
        }
        .sidebar-brand {
            padding: 20px 20px 10px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            color: #fff; font-weight: 700; font-size: 1.1rem;
        }
        .sidebar-nav { padding: 12px 0; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; color: rgba(255,255,255,.8);
            text-decoration: none; transition: all .2s;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,.15); color: #fff;
            border-left: 3px solid var(--accent);
        }
        .sidebar-nav .nav-section {
            font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;
            color: rgba(255,255,255,.4); padding: 12px 20px 4px;
        }
        .main-content { margin-left: 260px; padding: 24px; }
        .topbar {
            background: #fff; border-radius: 12px; padding: 12px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06); margin-bottom: 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,.06); }
        .stat-card { transition: transform .2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .badge { font-size: .78rem; }
        @media (max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-award-fill me-2" style="color:var(--accent)"></i>Awards Admin
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.results') }}" class="{{ request()->routeIs('admin.results') ? 'active' : '' }}">
            <i class="bi bi-trophy"></i> Results
        </a>
        <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i> Analytics
        </a>
        <div class="nav-section">Management</div>
        <a href="{{ route('admin.teachers') }}" class="{{ request()->routeIs('admin.teachers') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Teachers
        </a>
        <div class="nav-section">Reports</div>
        <a href="{{ route('admin.export.csv') }}">
            <i class="bi bi-filetype-csv"></i> Export CSV
        </a>
        <a href="{{ route('admin.print') }}" target="_blank">
            <i class="bi bi-printer"></i> Print Results
        </a>
        <div class="nav-section">Account</div>
        <a href="{{ route('welcome') }}" target="_blank">
            <i class="bi bi-eye"></i> View Voting Site
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" class="px-2 mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-box-arrow-left me-1"></i>Logout
            </button>
        </form>
    </nav>
</div>

<div class="main-content">
    <div class="topbar">
        <h5 class="mb-0 fw-bold" style="color:#1a237e">@yield('page-title', 'Dashboard')</h5>
        <span class="badge bg-primary">Admin Panel</span>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@yield('scripts')
</body>
</html>
