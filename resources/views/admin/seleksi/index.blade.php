@extends('layouts.admin')

@section('title', 'Seleksi Administrasi')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    .table-custom {
        font-size: 12px; 
    }
    .table-custom th, .table-custom td {
        padding: 8px 10px !important; 
        vertical-align: middle !important;
    }

    .table-custom thead th {
        text-align: center !important;
        background-color: #113883 !important;
        border: 1px solid #0a2b66 !important; 

    }

    .dataTables_filter input {
        height: 30px;
        font-size: 12px;
    }
</style>

<div class="container-fluid mt-4 mb-5">
    <h3 class="font-weight-bold text-dark mb-0">Seleksi & Perangkingan SAW</h3>
    <p class="text-muted small">Pilih lowongan untuk melihat hasil perhitungan SAW (Perangkingan) dari pelamar yang telah mengisi form administrasi.</p>
    
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            {{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="seleksiTable">
                    <thead class="table-dark text-white">
                        <tr>
                            <th width="40" class="no-sort">No</th>
                            <th>Posisi</th>
                            <th>Dealer</th>
                            <th width="120">Tgl Tutup</th>
                            <th width="150" class="no-sort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowongans as $lowongan)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="font-weight-bold">{{ $lowongan->posisi->nama_posisi ?? 'N/A' }}</td>
                            <td>{{ $lowongan->dealer->nama_dealer ?? 'N/A' }}</td>
                            <td class="text-center">{{ $lowongan->tgl_tutup->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.seleksi.show', $lowongan->id_lowongan) }}" class="btn btn-primary btn-xs px-3 shadow-sm">
                                     Lihat Hasil SAW
                                </a>
                            </td>
                        </tr>
                        @empty
                            {{-- DataTables akan menangani tampilan kosong secara otomatis --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
{{-- Library DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#seleksiTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": "no-sort" } 
            ],
            "pageLength": 10,
            "order": [[ 1, "asc" ]]
        });
    });
</script>
@endpush
@endsection