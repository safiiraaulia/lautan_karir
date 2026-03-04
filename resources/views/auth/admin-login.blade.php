<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Administration - Lautan Karir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --navy: #103783; }
        body { background-color: #f8fafc; font-family: 'Inter', 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        
        .login-card { width: 100%; max-width: 380px; border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); border-radius: 8px; background: #fff; }
        
        .card-header { background: transparent; border: none; padding: 40px 20px 10px; }
        .card-header h5 { color: var(--navy); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; font-size: 1.1rem; }
        
        .form-label { font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 5px; }
        .input-group { border: 1px solid #cbd5e1; border-radius: 6px; overflow: hidden; }
        .input-group-text { background: #f8fafc; border: none; color: #64748b; border-right: 1px solid #cbd5e1; font-size: 0.9rem; }
        .form-control { border: none; padding: 10px 12px; font-size: 14px; color: #334155; }
        .form-control:focus { box-shadow: none; background-color: #fdfdfd; }

        .btn-navy { background-color: var(--navy); color: #fff; font-weight: 700; padding: 12px; border-radius: 6px; transition: 0.2s; border: none; width: 100%; font-size: 13px; letter-spacing: 0.5px; }
        .btn-navy:hover { background-color: #0d2d6b; color: #fff; box-shadow: 0 4px 12px rgba(16, 55, 131, 0.15); }
    </style>
</head>
<body>

    <div class="login-card card">
        <div class="card-header text-center">
            <img src="{{ asset('img/logo.PNG') }}" alt="Logo Corporate" height="140" class="mb-4 mt-2">
            <h5 class="mb-1">HR Administration</h5>
            <p class="text-muted small">PT. Lautan Teduh Interniaga</p>
        </div>
        
        <div class="card-body px-4 pb-4">
            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 small mb-4 border-0 rounded-2" style="background-color: #fff1f2; color: #be123c;">
                    <i class="fas fa-exclamation-triangle me-1"></i> Akses ditolak. Periksa kembali akun Anda.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-uppercase">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan Username">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="rem">
                    <label class="form-check-label small text-muted" for="rem">Ingat Saya</label>
                </div>

                <button type="submit" class="btn btn-navy">
                    MASUK
                </button>
            </form>
        </div>
        
        <div class="card-footer bg-light text-center py-3 border-0">
            <small class="text-muted" style="font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                E-Recruitment System Dashboard
            </small>
        </div>
    </div>

</body>
</html>