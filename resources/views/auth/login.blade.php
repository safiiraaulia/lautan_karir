@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 text-center">
                    <h4 class="fw-bold text-navy">{{ __('Login Pelamar') }}</h4>
                    <p class="text-muted small">Masuk ke sistem Lautan Karir</p>
                </div>

                <div class="card-body px-4 pb-4">
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
                            <div class="bg-white p-2 rounded-circle text-danger me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="small fw-bold">{{ session('error') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small text-muted">{{ __('Alamat Email') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small text-muted">{{ __('Kata Sandi') }}</label>
                            <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">{{ __('Ingat Saya') }}</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link small p-0 text-decoration-none" href="{{ route('password.request') }}">{{ __('Lupa Password?') }}</a>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm" style="background-color: #103783; border: none;">
                                {{ __('Masuk Sekarang') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #103783 !important; }
    body { background-color: #f8f9fa; }
    .card { margin-top: 50px; }
</style>
@endsection