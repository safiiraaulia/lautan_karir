@extends('layouts.public')

@section('title', 'Dashboard Pelamar')

@section('content')
<div class="container py-5">
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        @if($pelamar->foto)
                            <img src="{{ Storage::url($pelamar->foto) }}" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="fw-bold mb-0">{{ $pelamar->nama }}</h5>
                    <p class="text-primary small mb-0">{{ $pelamar->username }}</p> 
                    <p class="text-muted small">{{ $pelamar->email }}</p>

                    <hr>

                    @if($isProfileComplete)
                        <div class="alert alert-success py-2 small mb-3">
                            <i class="fas fa-check-circle"></i> Profil Lengkap
                        </div>
                    @else
                        <div class="alert alert-warning py-2 small mb-3">
                            <i class="fas fa-exclamation-circle"></i> Profil Belum Lengkap
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ route('pelamar.profile.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> Edit Profil & Berkas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            @if(!$isProfileComplete)
                <div class="alert alert-warning shadow-sm border-0 mb-4">
                    <h5 class="alert-heading fw-bold"><i class="fas fa-clipboard-list me-2"></i> Lengkapi Profil Anda!</h5>
                    <p class="mb-0">Anda belum bisa melamar pekerjaan sebelum melengkapi data diri dan mengupload berkas (CV, KTP, dll).</p>
                    <hr>
                    <a href="{{ route('pelamar.profile.edit') }}" class="btn btn-warning btn-sm fw-bold">Lengkapi Sekarang</a>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i> Riwayat Lamaran Saya</h5>
                    <a href="{{ route('lowongan.index') }}" class="btn btn-sm btn-primary">+ Cari Lowongan Baru</a>
                </div>
                
                <div class="card-body p-0">
                    @if($lamarans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Posisi & Dealer</th>
                                        <th>Tanggal Lamar</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lamarans as $lamaran)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $lamaran->lowongan->posisi->nama_posisi }}</div>
                                            <div class="small text-muted">{{ $lamaran->lowongan->dealer->nama_dealer }}</div>
                                        </td>
                                        <td>{{ $lamaran->tgl_melamar->format('d M Y') }}</td>
                                        <td>
                                            @if($lamaran->status == 'Proses Administrasi')
                                                <span class="badge bg-warning text-dark">Sedang Diproses</span>
                                            @elseif($lamaran->status == 'Lolos Administrasi')
                                                <span class="badge bg-success">Lolos Administrasi</span>
                                                <div class="small text-success mt-1">Menunggu Jadwal Tes</div>
                                            @elseif($lamaran->status == 'Gagal Administrasi')
                                                <span class="badge bg-danger">Tidak Lolos</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $lamaran->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-light border" disabled>Lihat</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5>Belum ada lamaran aktif.</h5>
                            <p class="text-muted">Ayo mulai karirmu dengan melamar pekerjaan yang tersedia.</p>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-primary mt-2">Cari Lowongan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection