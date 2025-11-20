@extends('layouts.public')

@section('title', 'Cari Lowongan Kerja')

@section('content')
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Temukan Karir Impianmu</h1>
            <p class="lead">Bergabunglah dengan Lautan Teduh dan kembangkan potensimu.</p>
        </div>
    </div>

    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="row">
            @forelse($lowongans as $lowongan)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-job h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-primary">{{ $lowongan->posisi->nama_posisi }}</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">
                                {{ $lowongan->posisi->nama_posisi }}
                            </h5>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <i class="fas fa-building me-1"></i> {{ $lowongan->dealer->nama_dealer }}
                            </h6>
                            <p class="card-text text-secondary small mb-4">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $lowongan->dealer->kota }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-danger fw-bold">
                                        <i class="far fa-clock me-1"></i> Tutup: {{ $lowongan->tgl_tutup->format('d M Y') }}
                                    </small>
                                </div>
                                <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="btn btn-outline-primary w-100 stretched-link">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h4>Belum ada lowongan tersedia saat ini.</h4>
                        <p>Silakan cek kembali nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $lowongans->links() }}
        </div>
    </div>
@endsection