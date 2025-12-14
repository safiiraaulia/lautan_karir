@extends('layouts.admin')

@section('title', 'Laporan Rekrutmen')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Laporan Rekrutmen</h3>

    {{-- Filter --}}
    <div class="card mb-4 card-dark card-outline">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter mr-2"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.index') }}" method="GET">
                <div class="row">

                    {{-- Filter Lowongan --}}
                    <div class="col-md-4 mb-3">
                        <label>Lowongan</label>
                        <select name="lowongan_id" class="form-control">
                            <option value="">-- Semua Lowongan --</option>
                            @foreach($lowongans as $lowongan)
                                <option value="{{ $lowongan->id_lowongan }}"
                                    {{ request('lowongan_id') == $lowongan->id_lowongan ? 'selected' : '' }}>
                                    {{ $lowongan->posisi->nama_posisi }} - {{ $lowongan->dealer->singkatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-4 mb-3">
                        <label>Status Lamaran</label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="Proses Seleksi" {{ request('status') == 'Proses Seleksi' ? 'selected' : '' }}>Proses Seleksi</option>
                            <option value="Lolos Seleksi" {{ request('status') == 'Lolos Seleksi' ? 'selected' : '' }}>Lolos Seleksi</option>
                            <option value="Gagal Seleksi" {{ request('status') == 'Gagal Seleksi' ? 'selected' : '' }}>Gagal Seleksi</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Melamar</label>
                        <div class="input-group">
                            <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-dark"><i class="fas fa-search mr-1"></i> Tampilkan</button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-default">Reset</a>
                    </div>

                    {{-- Tombol Cetak --}}
                    <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" 
                        class="btn btn-secondary">
                        <i class="fas fa-print mr-1"></i> Cetak PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal</th>
                        <th>Nama Pelamar</th>
                        <th>Posisi Dilamar</th>
                        <th>Dealer</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($lamarans as $lamaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                            <td>{{ $lamaran->pelamar->nama }}</td>

                            <td>{{ $lamaran->lowongan->posisi->nama_posisi ?? '-' }}</td>

                            <td>{{ $lamaran->lowongan->dealer->nama_dealer ?? '-' }}</td>

                            <td>
                                @if($lamaran->status == 'Lolos Seleksi')
                                    <span class="badge bg-success">Lolos</span>
                                @elseif($lamaran->status == 'Gagal Seleksi')
                                    <span class="badge bg-danger">Gagal</span>
                                @else
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Tidak ada data yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
