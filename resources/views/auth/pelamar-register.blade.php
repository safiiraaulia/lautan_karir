@extends('layouts.public')
@section('title', 'Pendaftaran Pelamar - Lautan Karir')

@section('content')
<div class="d-flex align-items-center min-vh-100 py-5 main-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-navy text-white text-center py-4 border-0 header-gradient">
                        <h4 class="fw-bold mb-0">Buat Akun Baru</h4>
                        <small class="opacity-75">Bergabunglah bersama Lautan Karir</small>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            @php
                                $fields = [
                                    ['id' => 'nama', 'label' => 'Nama Lengkap', 'type' => 'text', 'icon' => 'fas fa-user', 'ph' => 'Masukkan nama lengkap', 'auto' => true],
                                    ['id' => 'email', 'label' => 'Alamat Email', 'type' => 'email', 'icon' => 'fas fa-envelope', 'ph' => 'contoh@email.com'],
                                    ['id' => 'nomor_whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text', 'icon' => 'fab fa-whatsapp', 'ph' => '0812xxxxxxxx'],
                                    ['id' => 'password', 'label' => 'Password', 'type' => 'password', 'icon' => 'fas fa-lock', 'ph' => 'Minimal 8 karakter'],
                                    ['id' => 'password-confirm', 'name' => 'password_confirmation', 'label' => 'Konfirmasi Password', 'type' => 'password', 'icon' => 'fas fa-check-circle', 'ph' => 'Ulangi password'],
                                ];
                            @endphp

                            @foreach($fields as $field)
                            <div class="mb-3">
                                <label for="{{ $field['id'] }}" class="form-label fw-bold text-navy small text-uppercase">{{ $field['label'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3 ps-3">
                                        <i class="{{ $field['icon'] }}"></i>
                                    </span>
                                    
                                    <input id="{{ $field['id'] }}" type="{{ $field['type'] }}" 
                                        class="form-control border-start-0 bg-light py-2 ps-2 @error($field['name'] ?? $field['id']) is-invalid @enderror {{ $field['type'] === 'password' ? 'border-end-0' : 'rounded-end-3' }}" 
                                        name="{{ $field['name'] ?? $field['id'] }}" 
                                        value="{{ old($field['name'] ?? $field['id']) }}" 
                                        placeholder="{{ $field['ph'] }}" 
                                        {{ isset($field['auto']) ? 'autofocus' : '' }} required autocomplete="{{ $field['id'] }}">

                                    @if($field['type'] === 'password')
                                    <button class="input-group-text bg-light border-start-0 text-muted rounded-end-3 toggle-password" type="button" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                    @endif
                                </div>

                                {{-- Tempat Muncul Pesan Validasi Real-time khusus Konfirmasi Password --}}
                                @if($field['id'] === 'password-confirm')
                                    <div id="match-message" class="small mt-1 fw-bold" style="display: none;"></div>
                                @endif

                                @error($field['name'] ?? $field['id'])
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            @endforeach

                            <div class="d-grid mb-4">
                                <button type="submit" id="btnSubmit" class="btn btn-navy btn-lg rounded-pill fw-bold shadow-sm transition-btn">
                                    Daftar Sekarang <i class="fas fa-user-plus ms-2 small"></i>
                                </button>
                            </div>
                            
                            <div class="text-center">
                                <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-navy transition-link">Login di sini</a></p>
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
    .main-bg { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); }
    .header-gradient { background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%) !important; }
    .form-control:focus { background-color: #fff; box-shadow: none; border-color: #4b6cb7; }
    .input-group-text { border-color: #ced4da; }
    
    /* State Fokus untuk Input Group */
    .input-group:focus-within .input-group-text { border-color: #4b6cb7; background-color: #fff; color: #103783 !important; }
    .input-group:focus-within .form-control { border-color: #4b6cb7; background-color: #fff; }

    .btn-navy { background-color: #103783; border: none; color: white; }
    .btn-navy:hover { background-color: #0a265e; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 55, 131, 0.3) !important; color: white; }
    .transition-btn, .transition-link { transition: all 0.3s ease; }
    .transition-link:hover { text-decoration: underline !important; color: #4b6cb7 !important; }
    
    /* Styling Pesan Validasi */
    .text-match { color: #198754; } /* Hijau */
    .text-mismatch { color: #dc3545; } /* Merah */
</style>

{{-- JAVASCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. FUNGSI TOGGLE SHOW/HIDE PASSWORD
        $(".toggle-password").click(function() {
            let input = $(this).closest('.input-group').find('input');
            let icon = $(this).find('i');

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        // 2. FUNGSI VALIDASI REAL-TIME PASSWORD MATCH
        function checkPasswordMatch() {
            let password = $("#password").val();
            let confirmPassword = $("#password-confirm").val();
            let messageDiv = $("#match-message");
            let btnSubmit = $("#btnSubmit");

            if (confirmPassword.length > 0) {
                messageDiv.show();
                if (password === confirmPassword) {
                    messageDiv.text("✓ Password cocok").removeClass("text-mismatch").addClass("text-match");
                    btnSubmit.prop("disabled", false).css("opacity", "1");
                } else {
                    messageDiv.text("× Password belum sama").removeClass("text-match").addClass("text-mismatch");
                    btnSubmit.prop("disabled", true).css("opacity", "0.7");
                }
            } else {
                messageDiv.hide();
                btnSubmit.prop("disabled", false);
            }
        }

        $("#password, #password-confirm").on("keyup", function() {
            checkPasswordMatch();
        });
    });
</script>
@endsection