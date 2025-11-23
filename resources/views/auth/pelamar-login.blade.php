@extends('layouts.public')

@section('title', 'Login Pelamar - Lautan Karir')

@section('content')
<div class="d-flex align-items-center min-vh-100 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-navy text-white text-center py-4 border-0" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%);">
                        <h4 class="fw-bold mb-0 text-white">Login Pelamar</h4>
                        <small class="opacity-75">Silakan masuk untuk melanjutkan</small>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        @if(session('error'))
                            <div class="alert alert-danger text-center mb-4 py-2 rounded-3 shadow-sm border-0 small">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pelamar.login') }}">
                            @csrf
                            @php
                                $fields = [
                                    ['name' => 'username', 'label' => 'Username', 'type' => 'text', 'icon' => 'user', 'ph' => 'Masukkan username'],
                                    ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'icon' => 'lock', 'ph' => '••••••••']
                                ];
                            @endphp

                            @foreach($fields as $f)
                                <div class="mb-4">
                                    <label for="{{ $f['name'] }}" class="form-label fw-bold text-navy small text-uppercase">{{ $f['label'] }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3 ps-3"><i class="fas fa-{{ $f['icon'] }}"></i></span>
                                        <input id="{{ $f['name'] }}" type="{{ $f['type'] }}" class="form-control border-start-0 bg-light py-2 ps-2 rounded-end-3 @error($f['name']) is-invalid @enderror" name="{{ $f['name'] }}" value="{{ $f['type']!='password'?old($f['name']):'' }}" required autocomplete="{{ $f['name']=='password'?'current-password':$f['name'] }}" {{ $loop->first?'autofocus':'' }} placeholder="{{ $f['ph'] }}">
                                    </div>
                                    @error($f['name']) <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            @endforeach

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small text-navy fw-bold" href="{{ route('password.request') }}">Lupa Password?</a>
                                @endif
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-navy btn-lg rounded-pill fw-bold shadow-sm transition-btn">Masuk Sekarang <i class="fas fa-arrow-right ms-2 small"></i></button>
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-0">Belum punya akun? <a href="{{ route('pelamar.register') }}" class="text-decoration-none fw-bold text-navy transition-link">Daftar di sini</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4"><small class="text-muted opacity-75">&copy; {{ date('Y') }} Lautan Teduh Interniaga</small></div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .form-control:focus { background-color: #fff; box-shadow: none; border-color: #4b6cb7; }
    .input-group-text { border-color: #ced4da; }
    .form-control:focus + .input-group-text, .form-control:focus ~ .input-group-text, .input-group:focus-within .input-group-text { border-color: #4b6cb7; background-color: #fff; color: #103783 !important; }
    .input-group:focus-within .form-control { border-color: #4b6cb7; }
    .btn-navy { background-color: #103783; border: none; color: white; }
    .btn-navy:hover { background-color: #0a265e; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 55, 131, 0.3) !important; color: white; }
    .transition-btn, .transition-link { transition: all 0.3s ease; }
    .transition-link:hover { text-decoration: underline !important; color: #4b6cb7 !important; }
</style>
@endsection