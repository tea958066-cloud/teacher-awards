<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Excellence Awards')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --primary-light: #3949ab;
            --accent: #ffd700;
            --success-bg: #e8f5e9;
        }
        body {
            background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .navbar { background: linear-gradient(90deg, var(--primary), var(--primary-light)) !important; }
        .step-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--accent); color: #1a237e;
            font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .card-header { border-radius: 16px 16px 0 0 !important; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-light); border-color: var(--primary-light); }
        .alert { border-radius: 12px; }
        .progress-steps { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .progress-step { display: flex; align-items: center; gap: 6px; font-size: .85rem; color: #666; }
        .progress-step.active { color: var(--primary); font-weight: 600; }
        .progress-step.done { color: #4caf50; }
        .progress-divider { color: #bbb; }
        footer { background: var(--primary); color: #fff; padding: 16px 0; margin-top: 40px; }
    </style>
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-dark py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="bi bi-award-fill me-2" style="color:var(--accent)"></i>Teacher Excellence Awards
        </a>
    </div>
</nav>

<div class="container py-4">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>

<footer class="text-center">
    <div class="container">
        <small><i class="bi bi-award me-1"></i>Teacher Excellence Awards Voting System &copy; {{ date('Y') }}</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
