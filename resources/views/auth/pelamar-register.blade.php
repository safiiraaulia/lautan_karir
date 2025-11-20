@extends('layouts.public')

@section('title', 'Pendaftaran Pelamar')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 text-primary fw-bold">Daftar Akun Baru</h3>
                
                <form method="POST" action="{{ route('pelamar.register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required autocomplete="nama" autofocus>
                        @error('nama')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp</label>
                        <input id="nomor_whatsapp" type="text" class="form-control @error('nomor_whatsapp') is-invalid @enderror" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" required>
                        @error('nomor_whatsapp')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
                    </div>

                    <div class="text-center">
                        Sudah punya akun? <a href="{{ route('pelamar.login') }}" class="text-decoration-none">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection