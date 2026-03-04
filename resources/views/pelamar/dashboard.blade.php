@extends('layouts.public')

@section('title', 'Dashboard Pelamar - Lautan Karir')

@section('content')
<div class="bg-navy text-white py-5 shadow-sm mb-n5" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%); padding-bottom: 100px !important;">
    <div class="container">
        <h2 class="fw-bold mb-1">Dashboard Saya</h2>
        <p class="opacity-75 mb-0">Kelola profil dan pantau status lamaran Anda di PT. Lautan Teduh Interniaga.</p>
    </div>
</div>

<div class="container" style="margin-top: -60px;">
    {{-- 1. NOTIFIKASI SUKSES (Session) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-lg rounded-4 mb-4 d-flex align-items-center" role="alert">
            <div class="bg-white p-2 rounded-circle text-success me-3 shadow-sm">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div class="fw-bold text-dark">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. ALERT KABAR TERBARU --}}
    @php
        $notifStatus = $lamarans->where('is_read', false)->whereIn('status', ['Lolos Seleksi', 'Gagal Seleksi'])->first();
    @endphp

    @if($notifStatus)
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-lg rounded-4 mb-4 d-flex align-items-center animate__animated animate__bounceIn" role="alert">
            <div class="bg-navy p-2 rounded-circle text-white me-3 shadow-sm">
                <i class="fas fa-bell fa-lg"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-dark">Ada Kabar Terbaru!</div>
                <div class="small text-muted">Status lamaran posisi <strong>{{ $notifStatus->lowongan->posisi->nama_posisi }}</strong> telah diperbarui. Cek hasilnya di bawah!</div>
            </div>
            {{-- Tombol X memicu fungsi untuk update database --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="markNotificationsAsRead()"></button>
        </div>
    @endif

    {{-- 3. ALERT PROFIL BELUM LENGKAP --}}
    @if(!$isProfileComplete)
        <div class="alert alert-warning border-0 shadow-lg rounded-4 mb-4 d-flex align-items-center animate__animated animate__headShake" role="alert">
            <div class="bg-white p-2 rounded-circle text-warning me-3 shadow-sm">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-dark">Profil Belum Lengkap!</div>
                <div class="small text-muted">Lengkapi Nama, No. WhatsApp, dan CV Anda agar proses seleksi berjalan lancar.</div>
            </div>
            <a href="{{ route('pelamar.profile.edit') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold shadow-sm">Lengkapi Sekarang</a>
        </div>
    @endif

    <div class="row">
        {{-- Kolom Kiri: Profil Card --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body text-center p-4 pt-5">
                    <div class="mb-4 position-relative d-inline-block">
                        @if($pelamar->foto)
                            <img src="{{ Storage::url($pelamar->foto) }}" class="rounded-circle shadow-sm border border-4 border-white" style="width: 130px; height: 130px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm border border-4 border-white" style="width: 130px; height: 130px;">
                                <i class="fas fa-user fa-4x text-secondary opacity-50"></i>
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0 mb-2 me-2">
                            <span class="badge {{ $isProfileComplete ? 'bg-success' : 'bg-warning text-dark' }} rounded-circle p-2 border border-2 border-white">
                                <i class="fas fa-{{ $isProfileComplete ? 'check' : 'exclamation' }}"></i>
                            </span>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1 text-navy">{{ $pelamar->nama }}</h5>
                    <p class="text-muted small mb-3">{{ $pelamar->email }}</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('pelamar.profile.edit') }}" class="btn btn-navy rounded-pill fw-bold shadow-sm py-2">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <small class="text-muted">Bergabung sejak {{ $pelamar->created_at->locale('id')->isoFormat('MMMM Y') }}</small>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Lamaran --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-4 border-bottom-0 d-flex justify-content-between align-items-center px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-navy"><i class="fas fa-history me-2"></i> Riwayat Lamaran</h5>
                    <a href="{{ route('lowongan.index') }}" class="btn btn-sm btn-navy rounded-pill px-3 shadow-sm transition-btn">
                        <i class="fas fa-plus me-1"></i> Cari Lowongan
                    </a>
                </div>
                
                <div class="card-body p-0">
                    @if($lamarans->count() > 0)
                        @php $sudahTes = \App\Models\JawabanTes::where('pelamar_id', $pelamar->id_pelamar)->exists(); @endphp
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3 border-0">Posisi</th>
                                        <th class="py-3 border-0">Tanggal</th>
                                        <th class="py-3 border-0 text-end pe-4">Status & Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lamarans as $lamaran)
                                        @php
                                            $style = match($lamaran->status) {
                                                'Lolos Seleksi'  => ['cl' => 'bg-soft-success text-success', 'ic' => 'fas fa-check-circle'],
                                                'Gagal Seleksi'  => ['cl' => 'bg-soft-danger text-danger', 'ic' => 'fas fa-times-circle'],
                                                'Proses Seleksi' => ['cl' => 'bg-soft-warning text-warning-dark', 'ic' => 'fas fa-clock'],
                                                default          => ['cl' => 'bg-soft-primary text-primary', 'ic' => 'fas fa-spinner fa-spin'],
                                            };
                                        @endphp
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-bold text-navy small">{{ $lamaran->lowongan->posisi->nama_posisi }}</div>
                                                <div class="text-muted" style="font-size: 11px;">{{ $lamaran->lowongan->dealer->nama_dealer }}</div>
                                            </td>
                                            <td class="py-3 text-muted" style="font-size: 11px;">{{ $lamaran->tgl_melamar->locale('id')->isoFormat('D MMM Y') }}</td>
                                            <td class="py-3 text-end pe-4">
                                                <div class="d-flex flex-column align-items-end gap-2">
                                                    <span class="badge {{ $style['cl'] }} rounded-pill px-3" style="font-size: 10px;">
                                                        <i class="{{ $style['ic'] }} me-1"></i> {{ $lamaran->status }}
                                                    </span>

                                                    @if(!$sudahTes)
                                                        <a href="{{ route('pelamar.tes.index') }}" class="btn btn-xs btn-navy rounded-pill px-3 py-1 fw-bold shadow-sm pulse-button" style="font-size: 10px;">
                                                            <i class="fas fa-pen-alt me-1"></i> Kerjakan Tes
                                                        </a>
                                                    @else
                                                        <span class="badge bg-soft-success text-success rounded-pill px-3" style="font-size: 10px;">
                                                            <i class="fas fa-check-circle me-1"></i> Psikotes Selesai
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted opacity-25"><i class="fas fa-folder-open fa-4x"></i></div>
                            <h6 class="fw-bold text-navy">Belum ada lamaran aktif.</h6>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-outline-navy rounded-pill px-4 btn-sm mt-2">Jelajahi Lowongan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function markNotificationsAsRead() {
        fetch('{{ route("pelamar.markRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                console.log("Status ditandai sudah dibaca");
            }
        });
    }
    window.onload = function() {
        markNotificationsAsRead();
    };
</script>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .btn-navy { background-color: #103783; color: #fff; border: none; }
    .bg-soft-primary { background-color: #eff6ff; } .text-primary { color: #1d4ed8 !important; }
    .bg-soft-success { background-color: #ecfdf5; } .text-success { color: #047857 !important; }
    .bg-soft-warning { background-color: #fffbeb; } .text-warning-dark { color: #b45309; }
    .bg-soft-danger { background-color: #fef2f2; } .text-danger { color: #b91c1c !important; }
    .pulse-button { animation: pulse-navy 2s infinite; }
    @keyframes pulse-navy {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 55, 131, 0.4); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(16, 55, 131, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 55, 131, 0); }
    }
</style>
@endsection