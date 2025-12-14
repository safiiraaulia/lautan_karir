@extends('layouts.public')

@section('title', 'Dashboard Pelamar - Lautan Karir')

@section('content')
<div class="bg-navy text-white py-5 shadow-sm mb-n5" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%); padding-bottom: 100px !important;">
    <div class="container"><h2 class="fw-bold mb-1">Dashboard Saya</h2><p class="opacity-75 mb-0">Kelola profil dan pantau status lamaran Anda.</p></div>
</div>

<div class="container" style="margin-top: -60px;">
    <div class="row">
        {{-- Kolom Kiri: Profil Card --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-body text-center p-4 pt-5">
                    <div class="mb-4 position-relative d-inline-block">
                        @if($pelamar->foto)
                            <img src="{{ Storage::url($pelamar->foto) }}" class="rounded-circle shadow-sm border border-4 border-white" style="width: 130px; height: 130px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm border border-4 border-white" style="width: 130px; height: 130px;"><i class="fas fa-user fa-4x text-secondary opacity-50"></i></div>
                        @endif
                        <div class="position-absolute bottom-0 end-0 mb-2 me-2">
                            <span class="badge {{ $isProfileComplete ? 'bg-success' : 'bg-warning text-dark' }} rounded-circle p-2 border border-2 border-white" title="{{ $isProfileComplete ? 'Lengkap' : 'Belum Lengkap' }}"><i class="fas fa-{{ $isProfileComplete ? 'check' : 'exclamation' }}"></i></span>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1 text-navy">{{ $pelamar->nama }}</h5>
                    <p class="text-muted small mb-3">{{ $pelamar->email }}</p>
                    <div class="d-grid gap-2"><a href="{{ route('pelamar.profile.edit') }}" class="btn btn-outline-navy rounded-pill fw-bold transition-btn"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></div>
                </div>
                <div class="card-footer bg-light border-0 py-3 text-center"><small class="text-muted">Bergabung sejak {{ $pelamar->created_at->format('M Y') }}</small></div>
            </div>
        </div>

        {{-- Kolom Kanan: Status & Riwayat --}}
        <div class="col-md-8">
            @if(!$isProfileComplete)
                <div class="alert alert-warning shadow-sm border-0 rounded-4 mb-4 d-flex align-items-center" role="alert">
                    <div class="bg-white p-2 rounded-circle text-warning me-3 shadow-sm"><i class="fas fa-clipboard-list fa-lg"></i></div>
                    <div class="flex-grow-1"><h6 class="alert-heading fw-bold mb-1">Lengkapi Profil Anda!</h6><p class="mb-0 small">Anda perlu melengkapi data diri & upload berkas sebelum melamar.</p></div>
                    <a href="{{ route('pelamar.profile.edit') }}" class="btn btn-warning btn-sm fw-bold rounded-pill px-3 shadow-sm">Lengkapi</a>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-4 border-bottom-0 d-flex justify-content-between align-items-center px-4">
                    <h5 class="mb-0 fw-bold text-navy"><i class="fas fa-history me-2 text-muted"></i> Riwayat Lamaran</h5>
                    <a href="{{ route('lowongan.index') }}" class="btn btn-sm btn-navy rounded-pill px-3 shadow-sm transition-btn"><i class="fas fa-plus me-1"></i> Cari Lowongan</a>
                </div>
                
                <div class="card-body p-0">
                    @if($lamarans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary small text-uppercase">
                                    <tr><th class="ps-4 py-3 border-0">Posisi</th><th class="py-3 border-0">Tanggal</th><th class="py-3 border-0 text-end pe-4">Status Seleksi</th></tr>
                                </thead>
                                <tbody>
                                    @php
                                    $statusMap = [
                                        'Proses Seleksi' => ['bg-soft-warning text-warning-dark', 'fas fa-clock', 'Proses Seleksi'],
                                        'Lolos Seleksi'  => ['bg-soft-success text-success', 'fas fa-check-circle', 'Lolos Seleksi'],
                                        'Gagal Seleksi'  => ['bg-soft-danger text-danger', 'fas fa-times-circle', 'Gagal Seleksi'],
                                    ];
                                @endphp

                                    @foreach($lamarans as $lamaran)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-bold text-navy">{{ $lamaran->lowongan->posisi->nama_posisi }}</div>
                                                <div class="small text-muted"><i class="far fa-building me-1"></i> {{ $lamaran->lowongan->dealer->nama_dealer }}</div>
                                            </td>
                                            <td class="py-3 text-muted small">{{ $lamaran->tgl_melamar->locale('id')->isoFormat('D MMM Y') }}</td>
                                            <td class="py-3 text-end pe-4">
                                            @php
                                                $s = $statusMap[$lamaran->status] ?? ['bg-secondary text-white', 'fas fa-question-circle', $lamaran->status];
                                            @endphp
                                                <span class="badge {{ $s[0] }} rounded-pill px-3">
                                                    <i class="{{ $s[1] }} me-1 small"></i> {{ $s[2] }}
                                                </span>
                                                
                                                @if($lamaran->is_read === false && !in_array($lamaran->status, ['Pending', 'Sedang Diproses']))
                                                    <span class="badge bg-danger rounded-circle p-1 ms-1" title="Hasil Seleksi Terbaru"></span>
                                                @endif
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
                            <p class="text-muted small mb-3">Ayo mulai karirmu dengan melamar pekerjaan yang tersedia.</p>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-outline-navy rounded-pill px-4 transition-btn">Jelajahi Lowongan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK MENANDAI NOTIFIKASI SUDAH DIBACA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unreadCount = document.querySelectorAll('.badge.bg-danger.rounded-circle').length;
        
        // Hanya jalankan jika ada notifikasi merah yang muncul
        if (unreadCount > 0) {
            // Asumsi: Anda membuat route baru: pelamar/mark-read di file web.php
            fetch('{{ route('pelamar.markRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    console.log('Notifikasi ditandai sudah dibaca.');
                }
            })
            .catch(error => {
                console.error('Gagal menandai notifikasi:', error);
            });
        }
    });
</script>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .btn-navy { background-color: #103783; border-color: #103783; color: #fff; }
    .btn-navy:hover { background-color: #0a265e; color: #fff; }
    .btn-outline-navy { color: #103783; border-color: #103783; }
    .btn-outline-navy:hover { background-color: #103783; color: #fff; }
    .bg-soft-warning { background-color: #fffbeb; } .text-warning-dark { color: #b45309; }
    .bg-soft-info { background-color: #e0f2fe; } .text-info-dark { color: #075985; }
    .bg-soft-success { background-color: #ecfdf5; } .text-success { color: #047857 !important; }
    .bg-soft-danger { background-color: #fef2f2; } .text-danger { color: #b91c1c !important; }
    .bg-soft-primary { background-color: #eff6ff; } .text-primary { color: #1d4ed8 !important; }
    .transition-btn { transition: all 0.3s ease; }
    .transition-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
</style>
@endsection