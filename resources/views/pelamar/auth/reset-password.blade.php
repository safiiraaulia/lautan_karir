@extends('layouts.public')

@section('title', 'Atur Ulang Password - Lautan Karir')

@section('content')
<div class="d-flex align-items-center min-vh-100 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-navy text-white text-center py-4 border-0" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%);">
                        <h4 class="fw-bold mb-0 text-white">Reset Password</h4>
                        <small class="opacity-75">Silakan masukkan password baru Anda</small>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form method="POST" action="{{ route('pelamar.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold text-navy small text-uppercase">Alamat Email</label>
                                <input id="email" type="email" class="form-control bg-light" name="email" value="{{ $email ?? old('email') }}" required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold text-navy small text-uppercase">Password Baru</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Minimal 8 karakter" autofocus>
                                @error('password')
                                    <span class="text-danger small"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-bold text-navy small text-uppercase">Konfirmasi Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Ulangi password baru">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-navy btn-lg rounded-pill fw-bold shadow-sm transition-btn">
                                    Simpan Password <i class="fas fa-save ms-2 small"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .btn-navy { background-color: #103783; border: none; color: white; }
    .btn-navy:hover { background-color: #0a265e; transform: translateY(-2px); color: white; }
    .transition-btn { transition: all 0.3s ease; }
</style>
@endsection