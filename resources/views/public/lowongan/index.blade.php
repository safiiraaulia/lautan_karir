@extends('layouts.public')

@section('title', 'Cari Lowongan Kerja - Lautan Teduh')

@section('content')
    <div class="bg-primary text-white text-center py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);">
        <div class="container">
            <div class="mb-4">
                <img src="{{ asset('img/logo_lautanteduhinterniaga.jpeg') }}" 
                     alt="Logo Lautan Teduh Interniaga" 
                     class="bg-white p-2 rounded shadow-sm" 
                     style="height: 80px; width: auto;">
                    </div>
            
            <h1 class="display-5 fw-bold mb-3">Temukan Karir Impianmu Bersama Kami</h1>
            <p class="lead mb-0 opacity-75">Bergabunglah dengan tim terbaik Lautan Teduh Interniaga dan kembangkan potensimu.</p>
        </div>
    </div>

    <div class="container mb-5">
        @if(session('error'))
            <div class="alert alert-danger text-center shadow-sm border-0 rounded-3 mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            @forelse($lowongans as $lowongan)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-job h-100 shadow-sm border-0 rounded-3 overflow-hidden position-relative">
                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">Aktif</span>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3">
                                <div class="d-inline-block bg-primary bg-opacity-10 text-primary p-3 rounded-circle mb-3">
                                    <i class="fas fa-briefcase fa-2x"></i>
                                </div>
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    {{ $lowongan->posisi->nama_posisi }}
                                </h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-building me-1"></i> {{ $lowongan->dealer->nama_dealer }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center text-secondary mb-2">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i> 
                                    <span>{{ $lowongan->dealer->kota }}</span>
                                </div>
                                <div class="d-flex align-items-center text-secondary">
                                    <i class="far fa-clock me-2 text-warning"></i> 
                                    <span>Tutup: {{ $lowongan->tgl_tutup->format('d M Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="btn btn-outline-primary w-100 fw-bold rounded-pill stretched-link">
                                    Lihat Detail & Lamar
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 py-3 text-center">
                            <small class="text-muted">Diposting {{ $lowongan->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light text-center py-5 shadow-sm border">
                        <div class="mb-3 text-muted">
                            <i class="fas fa-search fa-4x opacity-25"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Belum ada lowongan tersedia.</h4>
                        <p class="text-muted">Silakan cek kembali nanti untuk peluang karir terbaru.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $lowongans->links() }}
        </div>
    </div>

<style>
    /* Custom CSS untuk mempercantik Card */
    .card-job {
        transition: all 0.3s ease;
        top: 0;
    }
    .card-job:hover {
        top: -5px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        border-color: #007bff !important;
    }
    .bg-primary {
        background-color: #0d6efd !important;
    }
</style>
@endsection