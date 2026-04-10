@extends('layouts.admin')

@section('title', 'Laporan Rekrutmen')

@section('content')
{{-- Tambahan CSS untuk DataTables dan Spacing Lega --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    .table-custom {
        font-size: 12px; 
        color: #333;
    }
    
    .table-custom th, .table-custom td {
        padding: 8px 10px !important;
        vertical-align: middle !important;
    }

    .table-custom thead th {
        text-align: center !important;
        background-color: #113883 !important; 
        border: 1px solid #0a2b66 !important; 
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .italic-muted {
        color: #777;
        font-style: italic;
        font-size: 11px;
        line-height: 1.4;
    }

    .dataTables_filter input {
        height: 30px;
        font-size: 12px;
    }
</style>

<div class="container-fluid mt-4 mb-5">
    <h3 class="mb-4 fw-bold text-dark">Rekapitulasi Laporan Rekrutmen</h3>

    {{-- Filter Card --}}
    <div class="card mb-4 border-top border-dark shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 small fw-bold text-uppercase"><i class="fas fa-filter mr-2"></i> Filter Data Laporan</h5>
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
                            <span class="input-group-text bg-light">s/d</span>
                            <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3 border-top pt-3">
                    <div>
                        <button class="btn btn-sm px-4 shadow-sm text-white" style="background-color: #113883; border-color: #113883;">
                            <i class="fas fa-search mr-1"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm px-3">Reset</a>
                    </div>
                    <a href="{{ route('admin.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="fas fa-print mr-1"></i> Cetak Laporan (PDF)
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-custom mb-0 align-middle" id="laporanTable">
                    <thead>
                        <tr>
                            <th width="40" class="no-sort">NO</th>
                            <th width="90">TANGGAL</th>
                            <th>NAMA PELAMAR</th>
                            <th>DEALER</th>
                            <th width="80">SKOR</th>
                            <th>KESIMPULAN DISC</th>
                            <th>KESIMPULAN PAPIKOSTIK</th>
                            <th width="100">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lamarans as $lamaran)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $lamaran->tgl_melamar->format('d/m/Y') }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lamaran->pelamar->nama }}</div>
                                    <small class="text-muted">{{ $lamaran->lowongan->posisi->nama_posisi ?? '-' }}</small>
                                </td>
                                <td class="text-center">{{ $lamaran->lowongan->dealer->singkatan ?? '-' }}</td> 
                                <td class="text-center fw-bold text-primary">
                                    {{ $lamaran->skor_akhir_saw !== null ? number_format($lamaran->skor_akhir_saw, 4) : '-' }}
                                </td>
                                <td class="">
                                    {{ $lamaran->kesimpulan_disc ?? 'Belum ada kesimpulan' }}
                                </td>
                                <td class="">
                                    {{ $lamaran->kesimpulan_papi ?? 'Belum ada kesimpulan' }}
                                </td>
                                <td class="text-center">
                                    @php 
                                        $badge = match($lamaran->status) { 
                                            'Lolos Seleksi' => 'bg-success', 
                                            'Gagal Seleksi' => 'bg-danger', 
                                            default => 'bg-warning text-dark' 
                                        }; 
                                    @endphp
                                    <span class="badge {{ $badge }} px-2 py-1 rounded shadow-sm" style="font-size: 9px; text-transform: uppercase;">
                                        {{ str_replace(' Seleksi', '', $lamaran->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#laporanTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": "no-sort" }
            ],
            "pageLength": 10,
            "order": [[ 1, "desc" ]] 
        });
    });
</script>
@endpush
@endsection