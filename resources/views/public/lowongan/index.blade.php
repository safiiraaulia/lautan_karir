@extends('layouts.public')
@section('title', 'Cari Lowongan Kerja - Lautan Teduh')

@section('content')
<div class="hero text-white text-center py-5 mb-5 position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100 hero-bg"></div>
    <div class="container position-relative z-1 py-3">
        <div class="mb-4"><img src="{{ asset('img/logo_lautanteduhinterniaga.jpeg') }}" class="bg-white p-3 rounded-4 shadow-lg logo-hero"></div>
        <h1 class="display-5 fw-bold mb-3 tracking-tight">Temukan Karir Impianmu</h1>
        <p class="lead mb-0 opacity-90 fw-light mx-auto mw-700">Bergabunglah dengan tim terbaik <strong>PT. Lautan Teduh Interniaga</strong>.</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('error'))
        <div class="alert alert-danger text-center shadow-sm border-0 rounded-4 mb-4"><i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}</div>
    @endif

    <div class="row g-4">
        @forelse($lowongans as $job)
        <div class="col-md-6 col-lg-4">
            <div class="card card-j h-100 border-0 rounded-4 position-relative">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-2"><span class="badge bg-ss rounded-pill px-3 py-2 fw-bold"><i class="fas fa-circle small me-1 dot"></i> Aktif</span></div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-4 pt-2">
                        <h5 class="card-title fw-bold text-n mb-2 fs-4">{{ $job->posisi->nama_posisi }}</h5>
                        <div class="d-flex align-items-center text-muted"><i class="fas fa-building me-2 opacity-50"></i> <span class="fw-medium">{{ $job->dealer->nama_dealer }}</span></div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-center text-secondary mb-2 bg-light rounded-3 p-2">
                            <div class="me-3 text-center w-24"><i class="fas fa-map-marker-alt text-danger opacity-75"></i></div><span class="small fw-bold">{{ $job->dealer->kota }}</span>
                        </div>
                        <div class="d-flex align-items-center text-secondary bg-light rounded-3 p-2">
                            <div class="me-3 text-center w-24"><i class="far fa-calendar-alt text-n opacity-75"></i></div><span class="small">Tutup: <strong>{{ $job->tgl_tutup->locale('id')->isoFormat('D MMMM Y') }}</strong></span>
                        </div>
                    </div>
                    <div class="mt-auto"><a href="{{ route('lowongan.show', $job->id_lowongan) }}" class="btn btn-n w-100 fw-bold rounded-pill py-2 shadow-sm stretched-link">Lihat Detail & Lamar <i class="fas fa-arrow-right ms-2 small"></i></a></div>
                </div>
                <div class="card-footer bg-transparent border-top-0 py-3 text-center"><small class="text-muted fst-italic fs-085"><i class="far fa-clock me-1"></i> Diposting {{ $job->created_at->locale('id')->diffForHumans() }}</small></div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light text-center py-5 shadow-sm border rounded-4 bg-white">
                <div class="mb-3 text-muted"><i class="fas fa-search fa-4x opacity-10"></i></div>
                <h4 class="fw-bold text-n">Belum ada lowongan tersedia.</h4>
                <p class="text-muted">Silakan cek kembali nanti untuk peluang karir terbaru.</p>
            </div>
        </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-5">{{ $lowongans->links() }}</div>
</div>

<style>
    :root{--p:#103783;--s:#0a265e;--a:#4b6cb7;--t:#1e293b;}
    .hero{background:linear-gradient(135deg,var(--s) 0%,var(--a) 100%);box-shadow:0 4px 20px rgba(16,55,131,.15);border-radius:0 0 2rem 2rem}
    .hero-bg{background:radial-gradient(circle at 10% 20%,rgba(255,255,255,.05) 0%,transparent 20%),radial-gradient(circle at 90% 80%,rgba(255,255,255,.05) 0%,transparent 20%);pointer-events:none}
    .logo-hero{height:90px;width:auto;object-fit:contain}
    .text-n{color:var(--t)!important}
    .mw-700{max-width:700px} .w-24{width:24px} .fs-085{font-size:.85rem} .dot{font-size:8px}
    .card-j{background:#fff;box-shadow:0 4px 6px -1px rgba(0,0,0,.05);transition:all .4s cubic-bezier(.175,.885,.32,1.275);border:1px solid rgba(0,0,0,.05)!important}
    .card-j:hover{transform:translateY(-8px);box-shadow:0 20px 25px -5px rgba(0,0,0,.1);border-color:rgba(75,108,183,.3)!important}
    .bg-ss{background-color:#dcfce7!important;color:#166534!important}
    .btn-n{background-color:var(--p);color:#fff;border:1px solid var(--p);transition:all .3s ease}
    .btn-n:hover{background-color:var(--s);border-color:var(--s);color:#fff;box-shadow:0 4px 12px rgba(16,55,131,.25)}
    .page-item.active .page-link{background-color:var(--p);border-color:var(--p)}.page-link{color:var(--p)}
</style>
@endsection