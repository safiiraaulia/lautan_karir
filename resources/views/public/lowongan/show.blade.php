@extends('layouts.public')
@section('title', $lowongan->posisi->nama_posisi . ' - Lautan Karir')

@section('content')
<div class="hero text-white py-5 shadow-sm position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100 hero-bg"></div>
    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-soft-warn text-warn-d mb-3 px-3 py-2 rounded-pill fw-bold"><i class="fas fa-briefcase me-1"></i> Full Time</span>
                <h1 class="display-4 fw-bold mb-2 text-shad">{{ $lowongan->posisi->nama_posisi }}</h1>
                <p class="lead opacity-90 mb-0 fw-light"><i class="fas fa-building me-2"></i> {{ $lowongan->dealer->nama_dealer }} <span class="mx-2 opacity-50">|</span> <i class="fas fa-map-marker-alt me-2"></i> {{ $lowongan->dealer->kota }}</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="{{ Auth::guard('pelamar')->check() ? route('pelamar.lamaran.create', $lowongan->id_lowongan) : route('pelamar.login') }}" class="btn btn-light btn-lg fw-bold text-n px-5 rounded-pill shadow-lg trans-btn">
                    <i class="fas {{ Auth::guard('pelamar')->check() ? 'fa-paper-plane' : 'fa-sign-in-alt' }} me-2"></i> {{ Auth::guard('pelamar')->check() ? 'Lamar Sekarang' : 'Login untuk Melamar' }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container my-5"><div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4"><div class="card-body p-4 p-md-5">
            <h4 class="fw-bold text-n mb-4 border-bottom pb-3"><i class="fas fa-align-left me-2 text-muted"></i> Deskripsi Pekerjaan</h4>
            <div class="text-secondary desc-txt">{!! nl2br(e($lowongan->deskripsi ?? 'Tidak ada deskripsi detail untuk lowongan ini.')) !!}</div>
        </div></div>
        <div class="card border-0 shadow-sm rounded-4"><div class="card-body p-4 p-md-5">
            <h4 class="fw-bold text-n mb-4 border-bottom pb-3"><i class="fas fa-clipboard-list me-2 text-muted"></i> Kriteria & Persyaratan</h4>
            <div class="row g-3">
                @forelse($lowongan->posisi->kriteria as $k)
                <div class="col-md-6"><div class="d-flex align-items-center p-3 bg-soft-n rounded-3 h-100 border border-light">
                    <div class="bg-white p-2 rounded-circle text-n me-3 shadow-sm icon-sq"><i class="fas fa-check small"></i></div>
                    <div><h6 class="mb-1 fw-bold text-n">{{ $k->nama_kriteria }}</h6></div>
                </div></div>
                @empty <div class="col-12 text-muted fst-italic">Kriteria spesifik belum dicantumkan.</div>
                @endforelse
            </div>
        </div></div>
    </div>
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm rounded-4 mb-4 sticky-top bg-white" style="top:100px;z-index:1"><div class="card-body p-4">
            <h5 class="fw-bold text-n mb-4">Ringkasan Lowongan</h5>
            <ul class="list-unstyled">
                @foreach([
                    ['i'=>'far fa-calendar-alt', 'c'=>'secondary', 'l'=>'Tanggal Dibuka', 'v'=>$lowongan->tgl_buka->locale('id')->isoFormat('D MMMM Y'), 'vc'=>'dark'],
                    ['i'=>'far fa-calendar-times', 'c'=>'danger', 'l'=>'Batas Lamaran', 'v'=>$lowongan->tgl_tutup->locale('id')->isoFormat('D MMMM Y'), 'vc'=>'danger'],
                    ['i'=>'far fa-id-badge', 'c'=>'navy', 'l'=>'Kode Posisi', 'v'=>$lowongan->posisi->kode_posisi, 'vc'=>'dark']
                ] as $d)
                <li class="mb-4 d-flex align-items-center">
                    <div class="icon-box me-3 bg-light text-{{ $d['c'] == 'navy' ? 'n' : $d['c'] }} rounded-circle d-flex center-box icon-lg"><i class="{{ $d['i'] }}"></i></div>
                    <div><small class="text-muted d-block text-uppercase fw-bold ls-05">{{ $d['l'] }}</small><span class="fw-bold text-{{ $d['vc'] }}">{{ $d['v'] }}</span></div>
                </li>
                @endforeach
            </ul>
            <hr class="my-4 opacity-10">
            <div class="d-grid"><a href="{{ route('home') }}" class="btn btn-outline-n rounded-pill py-2 fw-bold"><i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar</a></div>
        </div></div>
    </div>
</div></div>

<style>
    :root{--p:#103783;--s:#0a265e;--a:#4b6cb7;--t:#1e293b;}
    .hero{background:linear-gradient(135deg,var(--s) 0%,var(--a) 100%);border-radius:0 0 2rem 2rem}
    .hero-bg{background:radial-gradient(circle at 10% 20%,rgba(255,255,255,.05) 0%,transparent 20%),radial-gradient(circle at 90% 80%,rgba(255,255,255,.05) 0%,transparent 20%);pointer-events:none}
    .text-shad{text-shadow:0 2px 4px rgba(0,0,0,.2)}
    .text-n{color:var(--t)!important}.bg-soft-n{background-color:#f1f5f9}.bg-soft-warn{background-color:#fef3c7}.text-warn-d{color:#92400e}
    .btn-light{color:var(--p);border:none}.btn-light:hover{background-color:#f8fafc;transform:translateY(-2px)}
    .btn-outline-n{color:var(--p);border-color:var(--p)}.btn-outline-n:hover{background-color:var(--p);color:#fff}
    .trans-btn{transition:all .3s ease}.card{border:1px solid rgba(0,0,0,.04)!important}
    .desc-txt{line-height:1.8;font-size:1.05rem} .icon-sq{width:40px;height:40px;display:flex;align-items:center;justify-content:center}
    .center-box{align-items:center;justify-content:center} .icon-lg{width:45px;height:45px} .ls-05{font-size:.7rem;letter-spacing:.5px}
    .text-n{color: var(--p) !important} /* Fix for sidebar text-navy class override logic */
</style>
@endsection