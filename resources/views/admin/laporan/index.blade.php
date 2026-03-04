@extends('layouts.admin')

@section('title', 'Laporan Rekrutmen')

@section('content')
<div class="container mt-4 mb-5">
    <h3 class="mb-4 fw-bold text-dark">Rekapitulasi Laporan Rekrutmen</h3>

    {{-- Filter Card --}}
    <div class="card mb-4 border-top border-dark shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 small fw-bold"><i class="fas fa-filter mr-2"></i> FILTER DATA</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3 small">
                        <label class="fw-bold">Pilih Lowongan</label>
                        <select name="lowongan_id" class="form-control form-control-sm">
                            <option value="">-- Semua Lowongan --</option>
                            @foreach($lowongans as $lowongan)
                                <option value="{{ $lowongan->id_lowongan }}" {{ request('lowongan_id') == $lowongan->id_lowongan ? 'selected' : '' }}>
                                    {{ $lowongan->posisi->nama_posisi }} - {{ $lowongan->dealer->singkatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3 small">
                        <label class="fw-bold">Status Seleksi</label>
                        <select name="status" class="form-control form-control-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="Proses Seleksi" {{ request('status') == 'Proses Seleksi' ? 'selected' : '' }}>Proses Seleksi</option>
                            <option value="Lolos Seleksi" {{ request('status') == 'Lolos Seleksi' ? 'selected' : '' }}>Lolos Seleksi</option>
                            <option value="Gagal Seleksi" {{ request('status') == 'Gagal Seleksi' ? 'selected' : '' }}>Gagal Seleksi</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3 small">
                        <label class="fw-bold">Rentang Tanggal</label>
                        <div class="input-group input-group-sm">
                            <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                            <span class="input-group-text small">s/d</span>
                            <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <div>
                        <button class="btn btn-dark btn-sm px-4"><i class="fas fa-search mr-1"></i> Terapkan</button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                    </div>
                    <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="fas fa-print mr-1"></i> Cetak Laporan (PDF)
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 small">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th width="40">NO</th>
                            <th width="100">TANGGAL</th>
                            <th>NAMA PELAMAR</th>
                            <th>POSISI</th>
                            <th>DEALER</th>
                            <th width="110">SKOR SAW</th> {{-- KOLOM BARU --}}
                            <th width="130">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lamarans as $lamaran)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                                <td class="fw-bold">{{ $lamaran->pelamar->nama }}</td>
                                <td>{{ $lamaran->lowongan->posisi->nama_posisi ?? '-' }}</td>
                                <td class="text-center">{{ $lamaran->lowongan->dealer->singkatan ?? '-' }}</td> 
                                <td class="text-center fw-bold text-primary">
                                    {{ $lamaran->skor_akhir_saw !== null ? number_format($lamaran->skor_akhir_saw, 4) : '-' }}
                                </td>

                                <td class="text-center">
                                    @php
                                        $badge = match($lamaran->status) {
                                            'Lolos Seleksi' => 'bg-success',
                                            'Gagal Seleksi' => 'bg-danger',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }} px-3 rounded-pill" style="font-size: 9px;">
                                        {{ $lamaran->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data rekrutmen yang tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection