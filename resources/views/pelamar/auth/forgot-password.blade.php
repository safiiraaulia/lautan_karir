@extends('layouts.public')

@section('title', 'Lupa Password - Lautan Karir')

@section('content')
<div class="d-flex align-items-center min-vh-100 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-navy text-white text-center py-4 border-0" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%);">
                        <h4 class="fw-bold mb-0 text-white">Lupa Password</h4>
                        <small class="opacity-75">Kami akan kirimkan link reset ke email Anda</small>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        @if (session('status'))
                            <div class="alert alert-success text-center mb-4 py-2 rounded-3 shadow-sm border-0 small">
                                <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pelamar.password.email') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold text-navy small text-uppercase">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3 ps-3">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" 
                                           type="email" 
                                           class="form-control border-start-0 bg-light py-2 ps-2 rounded-end-3 @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autofocus 
                                           placeholder="contoh@email.com">
                                </div>
                                @error('email') 
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span> 
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-navy btn-lg rounded-pill fw-bold shadow-sm transition-btn">
                                    Kirim Link Reset <i class="fas fa-paper-plane ms-2 small"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-0">Ingat password Anda? <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-navy transition-link">Kembali Login</a></p>
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
    .btn-navy { background-color: #103783; border: none; color: white; }
    .btn-navy:hover { background-color: #0a265e; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 55, 131, 0.3) !important; color: white; }
    .transition-btn, .transition-link { transition: all 0.3s ease; }
    .transition-link:hover { text-decoration: underline !important; color: #4b6cb7 !important; }
</style>
@endsection