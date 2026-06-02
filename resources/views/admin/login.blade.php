<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Teacher Excellence Awards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg,#1a237e 0%,#4a148c 100%); min-height:100vh; display:flex; align-items:center; }
        .login-card { border-radius:20px; box-shadow:0 16px 48px rgba(0,0,0,.3); border:none; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4">
                <div style="font-size:3rem;color:#ffd700"><i class="bi bi-award-fill"></i></div>
                <h3 class="text-white fw-bold mt-2">Teacher Excellence Awards</h3>
                <p class="text-white-50">Administrator Panel</p>
            </div>
            <div class="card login-card p-4">
                <h4 class="fw-bold mb-4 text-center" style="color:#1a237e">
                    <i class="bi bi-shield-lock-fill me-2"></i>Admin Login
                </h4>

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Admin Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password" class="form-control form-control-lg"
                                   placeholder="Enter admin password" required autofocus>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary btn-lg" style="background:#1a237e;border-color:#1a237e;border-radius:10px">
                            <i class="bi bi-unlock-fill me-2"></i>Login
                        </button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('welcome') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Back to Voting Site
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
