@extends('layouts.public')

@section('title', 'Formulir Seleksi - ' . $lowongan->posisi->nama_posisi)

@section('content')
{{-- Hero Header --}}
<div class="bg-navy text-white py-5 mb-n5 shadow-sm" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%); padding-bottom: 80px !important;">
    <div class="container text-center">
        <h3 class="fw-bold mb-1">Seleksi Administrasi</h3>
        <p class="opacity-75 mb-0">Mohon lengkapi data kualifikasi berikut sesuai dengan kondisi Anda yang sebenarnya.</p>
    </div>
</div>

<div class="container" style="margin-top: -40px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4 text-center">
                    <h5 class="text-navy fw-bold mb-1">{{ $lowongan->posisi->nama_posisi }}</h5>
                    <span class="badge bg-soft-navy text-navy rounded-pill px-3 py-2 border">
                        <i class="fas fa-building me-1"></i> {{ $lowongan->dealer->nama_dealer }}
                    </span>
                </div>

                <div class="card-body p-4 p-md-5 bg-light-subtle" style="background-color: #f8f9fa;">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 small">
                            <ul class="mb-0 ps-3">@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('pelamar.lamaran.store', $lowongan->id_lowongan) }}" method="POST">
                        @csrf
                        
                        @forelse($kriterias as $kriteria)
                            <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden bg-white">
                                <div class="card-header bg-navy text-white py-3 px-4 d-flex align-items-center">
                                    <span class="badge bg-white text-navy me-3 rounded-pill">#{{ $loop->iteration }}</span>
                                    <h6 class="mb-0 fw-bold lh-base">
                                        {{ $kriteria->pertanyaan ?? $kriteria->nama_kriteria }}
                                    </h6>
                                </div>
                                <div class="card-body p-4">
                                    @if($kriteria->opsi->isEmpty())
                                        <div class="alert alert-warning small mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i> Opsi jawaban belum disetting.
                                        </div>
                                    @else
                                        <div class="d-grid gap-2">
                                            @foreach($kriteria->opsi as $skala)
                                                {{-- PERBAIKAN UTAMA DI SINI --}}
                                                @php
                                                    // Ambil ID yang benar (id_skala atau id)
                                                    $idSkala = $skala->id_skala ?? $skala->id;
                                                @endphp

                                                <div class="position-relative">
                                                    {{-- ID dan FOR harus Unik --}}
                                                <input class="form-check-input input-option" 
                                                    style="position: absolute; opacity: 0; pointer-events: none;"
                                                    type="radio" 
                                                    name="jawaban[{{ $kriteria->id_kriteria }}]" 
                                                    id="opt_{{ $idSkala }}" 
                                                    value="{{ $idSkala }}" 
                                                    required>
                                                    
                                                    <label class="btn btn-outline-light text-dark w-100 text-start p-3 rounded-3 border shadow-sm option-label transition-btn" 
                                                           for="opt_{{ $idSkala }}">
                                                        <div class="d-flex align-items-center">
                                                            <div class="check-icon bg-light text-muted rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                                                 style="width: 24px; height: 24px;">
                                                                 <i class="fas fa-circle" style="font-size: 8px;"></i>
                                                            </div>
                                                            <span class="fw-medium">{{ $skala->deskripsi }}</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center border-0 shadow-sm py-4">
                                Tidak ada tes kualifikasi khusus. Silakan langsung kirim lamaran.
                            </div>
                        @endforelse

                        <div class="card border-0 shadow-sm mt-5 bg-white rounded-3">
                            <div class="card-body p-4 text-center">
                                <p class="text-muted small mb-3">
                                    Dengan menekan tombol di bawah, saya menyatakan data yang saya isi adalah benar.
                                </p>
                                <div class="d-grid gap-3">
                                    <button type="submit" class="btn btn-navy btn-lg rounded-pill fw-bold shadow-lg transition-btn py-3">
                                        <i class="fas fa-paper-plane me-2"></i> KIRIM LAMARAN SEKARANG
                                    </button>
                                    <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="btn btn-light text-muted fw-bold rounded-pill">Batal</a>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4 mb-5">
                <small class="text-muted opacity-75">&copy; {{ date('Y') }} Lautan Teduh Interniaga</small>
            </div>
        </div>
    </div>
</div>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .bg-soft-navy { background-color: #eef2f6; }
    
    .input-option:checked + .option-label {
        background-color: #103783;
        color: white !important;
        border-color: #103783;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(16, 55, 131, 0.2) !important;
    }
    .input-option:checked + .option-label .check-icon {
        background-color: white !important;
        color: #103783 !important;
    }
    .input-option:checked + .option-label .check-icon i::before {
        content: "\f00c"; 
        font-family: "Font Awesome 5 Free"; 
        font-weight: 900;
    }
    
    .option-label:hover { background-color: #fff; border-color: #103783; }
    .btn-navy { background-color: #103783; border: none; color: white; }
    .btn-navy:hover { background-color: #0a265e; color: white; transform: translateY(-2px); }
    .transition-btn { transition: all 0.2s ease; }
</style>
@endsection