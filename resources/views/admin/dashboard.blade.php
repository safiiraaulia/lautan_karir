@extends('layouts.admin')

@section('title', 'Dashboard HRD/Admin')

@section('content')
<div class="container mt-4">
    
    <h3 class="mb-4">Overview Rekrutmen</h3>

    <div class="row">
        
        <div class="col-lg-6 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPelamar }}</h3>
                    <p>Total Pelamar Terdaftar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.pelamar.index') }}" class="small-box-footer">
                    Lihat Semua Pelamar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-6 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $lowonganBuka }}</h3>
                    <p>Lowongan Sedang Dibuka</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('admin.lowongan.index') }}" class="small-box-footer">
                    Kelola Lowongan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">10 Lamaran Terbaru Masuk</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
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
                                    <td>{{ $lamaran->pelamar->nama }}</td>
                                    <td>{{ $lamaran->lowongan->posisi->nama_posisi ?? '-' }}</td>
                                    <td>{{ $lamaran->lowongan->dealer->singkatan ?? '-' }}</td>
                                    <td>
                                        @if($lamaran->status == 'Lolos Administrasi')
                                            <span class="badge badge-success">Lolos Admin</span>
                                        @elseif($lamaran->status == 'Gagal Administrasi')
                                            <span class="badge badge-danger">Gagal Admin</span>
                                        @else
                                            <span class="badge badge-warning">Proses Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" class="btn btn-sm btn-primary">
                                            Lihat Profil
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada lamaran yang masuk.</td>
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