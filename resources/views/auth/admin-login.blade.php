<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Lautan Karir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { width: 100%; max-width: 400px; border: none; box-shadow: 0 0 20px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; padding: 25px 20px; }
        .btn-primary { background-color: #3b82f6; border: none; padding: 10px; font-weight: 600; }
        .btn-primary:hover { background-color: #2563eb; }
        .form-control:focus { box-shadow: none; border-color: #3b82f6; }
        .input-group-text { background: #fff; border-right: 0; color: #9ca3af; }
        .form-control { border-left: 0; padding-left: 0; }
    </style>
</head>
<body>

    <div class="login-card card">
        <div class="card-header text-center">
            <img src="{{ asset('img/logo_lautanteduhinterniaga.jpeg') }}" alt="Logo" height="45" class="mb-3">
            <h5 class="fw-bold text-dark mb-0">Portal Administrator</h5>
            <small class="text-muted">Silakan login untuk mengelola sistem</small>
        </div>
        <div class="card-body p-4 bg-white">
            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 small mb-3 border-0 rounded-1">
                    <ul class="mb-0 ps-3">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">USERNAME</label>
                    <div class="input-group border rounded">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                    <div class="input-group border rounded">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" required placeholder="Masukkan password">
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="rem">
                    <label class="form-check-label small text-muted" for="rem">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-1">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk Dashboard
                </button>
            </form>
        </div>
        <div class="card-footer bg-light text-center py-3 border-top">
            <small class="text-muted" style="font-size: 11px;">&copy; {{ date('Y') }} Lautan Teduh Interniaga</small>
        </div>
    </div>

</body>
</html>