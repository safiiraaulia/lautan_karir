@extends('layouts.admin')

@section('title', 'Dashboard HRD/Admin')

@section('content')

<style>
    .badge-soft {
        font-weight: 600;
        padding: 0.25rem 0.75rem; 
        border-radius: 50px;
        font-size: 12px;
        display: inline-block;
        border: 1px solid transparent;
        line-height: 1.5;
        text-align: center;
        vertical-align: middle;
    }
    
    .badge-soft-success { background-color: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }
    .badge-soft-danger { background-color: #ffebee; color: #c62828; border-color: #ffcdd2; }
    .badge-soft-warning { background-color: #fff8e1; color: #f57f17; border-color: #ffecb3; }
</style>

<div class="container-fluid">
    <div class="mb-4">
        <h3 class="font-weight-bold text-dark">Overview Rekrutmen</h3>
        <p class="text-muted">Ringkasan aktivitas & data terbaru</p>
    </div>

    <!-- STAT CARDS -->
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #36a2eb, #1f78c1); color: white; border-radius: 16px;">
                <div class="inner">
                    <h3 class="font-weight-bold">{{ $totalPelamar }}</h3>
                    <p>Total Pelamar Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.pelamar.index') }}" class="small-box-footer text-white">Lihat Semua Pelamar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="small-box shadow-sm" style="background: linear-gradient(135deg, #28a745, #1e7c34); color: white; border-radius: 16px;">
                <div class="inner">
                    <h3 class="font-weight-bold">{{ $lowonganBuka }}</h3>
                    <p>Lowongan Tersedia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('admin.lowongan.index') }}" class="small-box-footer text-white">Kelola Lowongan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- TABLE LIST -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-lg border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 font-weight-bold">10 Lamaran Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Pelamar</th>
                                    <th>Posisi</th>
                                    <th>Dealer</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lamaranTerbaru as $lamaran)
                                <tr>
                                    <td class="font-weight-medium">{{ $lamaran->pelamar->nama }}</td>
                                    <td>{{ $lamaran->lowongan->posisi->nama_posisi ?? '-' }}</td>
                                    <td>{{ $lamaran->lowongan->dealer->nama_dealer ?? '-' }}</td>
                                   <td>
                                    @php
                                        $status = strtolower($lamaran->status);
                                    @endphp

                                    @if(str_contains($status, 'lolos'))
                                        <span class="badge-soft badge-soft-success">Lolos Seleksi</span>
                                    @elseif(str_contains($status, 'gagal'))
                                        <span class="badge-soft badge-soft-danger">Gagal</span>
                                    @else
                                        <span class="badge-soft badge-soft-warning">Dalam Pengecekan</span>
                                    @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">Lihat Profil</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada lamaran yang masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
