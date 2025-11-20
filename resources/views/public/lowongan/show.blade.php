@extends('layouts.public')

@section('title', $lowongan->posisi->nama_posisi . ' - Lautan Karir')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('lowongan.index') }}">Lowongan</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $lowongan->posisi->nama_posisi }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary mb-1">{{ $lowongan->posisi->nama_posisi }}</h2>
                    <h5 class="text-muted mb-4">
                        {{ $lowongan->dealer->nama_dealer }} - {{ $lowongan->dealer->kota }}
                    </h5>

                    <hr>

                    <h5 class="fw-bold mt-4">Deskripsi Pekerjaan</h5>
                    <div class="text-secondary mb-4">
                        {!! nl2br(e($lowongan->deskripsi)) !!}
                    </div>

                    <h5 class="fw-bold mt-4">Kualifikasi & Syarat</h5>
                    @if($lowongan->posisi->kriteria->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($lowongan->posisi->kriteria as $kriteria)
                                <li class="list-group-item bg-transparent ps-0">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    {{ $kriteria->nama_kriteria }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Kualifikasi umum perusahaan berlaku.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow border-primary mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Ringkasan</h5>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li class="mb-2">
                            <i class="far fa-calendar-alt text-primary me-2"></i> 
                            Dibuka: {{ $lowongan->tgl_buka->format('d M Y') }}
                        </li>
                        <li class="mb-2 text-danger fw-bold">
                            <i class="far fa-clock me-2"></i> 
                            Ditutup: {{ $lowongan->tgl_tutup->format('d M Y') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                            {{ $lowongan->dealer->kota }}
                        </li>
                    </ul>

                    <div class="d-grid gap-2">
                        @if(Auth::guard('pelamar')->check())
                            {{-- <a href="{{ route('pelamar.lamaran.create', $lowongan->id_lowongan) }}" class="btn btn-primary btn-lg"> --}}
                            <button class="btn btn-primary btn-lg" disabled>Lamar Sekarang (Segera Hadir)</button>
                        @else
                            <a href="{{ route('pelamar.login') }}" class="btn btn-primary btn-lg">Login untuk Melamar</a>
                            <a href="{{ route('pelamar.register') }}" class="btn btn-outline-primary">Daftar Akun Baru</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="alert alert-light border shadow-sm">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> 
                    Pastikan profil Anda sudah lengkap sebelum melamar posisi ini.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection