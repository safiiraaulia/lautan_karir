@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Dealer' : 'Master Dealer')

@section('content')
{{-- Tambahan CSS untuk DataTables dan Pengecilan Font --}}
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
        color: white !important;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: 1px solid #0a2b66 !important; 
    }

    .table-custom tbody td {
        border: 1px solid #dee2e6;
    }

    .dataTables_filter input {
        height: 30px;
        font-size: 12px;
    }
</style>

<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">
                {{ $isTrash ? 'Data Dealer Terhapus' : 'Master Dealer' }}
            </h3>
        </div>

        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.dealer.index') }}" class="btn btn-secondary shadow-sm btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.dealer.create') }}" class="btn btn-primary shadow-sm btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Dealer
                </a>
                <a href="{{ route('admin.dealer.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm btn-sm">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4 card-black-outline">
        <div class="card-body"> 
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="dealerTable">
                    <thead>
                        <tr>
                            <th width="120">KODE DEALER</th>
                            <th>NAMA DEALER</th>
                            <th>KOTA</th>
                            <th>SINGKATAN</th>
                            <th width="{{ $isTrash ? '200' : '150' }}" class="no-sort">AKSI</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dealers as $row)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $row->kode_dealer }}</td>
                                <td>{{ $row->nama_dealer }}</td>
                                <td>{{ $row->kota }}</td>
                                <td class="text-center">{{ $row->singkatan }}</td>

                                <td class="text-center">
                                    @if($isTrash)
                                        <button class="btn btn-success btn-xs px-2 shadow-sm" 
                                                onclick="confirmRestore('{{ route('admin.dealer.restore', $row->kode_dealer) }}', '{{ $row->nama_dealer }}')">
                                             Pulihkan
                                        </button>

                                        <form action="{{ route('admin.dealer.force-delete', $row->kode_dealer) }}"
                                              method="POST" id="form-force-{{ $row->kode_dealer }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-dark btn-xs px-2 shadow-sm"
                                                    onclick="confirmForceDelete('{{ $row->kode_dealer }}', '{{ $row->nama_dealer }}')">
                                                    Hapus
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.dealer.edit', $row->kode_dealer) }}"
                                           class="btn btn-warning btn-xs shadow-sm px-2">
                                             Edit
                                        </a>

                                        <form action="{{ route('admin.dealer.destroy', $row->kode_dealer) }}"
                                              method="POST" id="form-delete-{{ $row->kode_dealer }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-xs shadow-sm px-2"
                                                    onclick="confirmDelete('{{ $row->kode_dealer }}', '{{ $row->nama_dealer }}')">
                                                     Hapus
                                            </button>
                                        </form>
                                    @endif
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
        $('#dealerTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": "no-sort" }
            ],
            "pageLength": 10,
            "order": [[ 0, "asc" ]] 
        });
    });

    function confirmDelete(kode, nama) {
        Swal.fire({
            title: 'Hapus Dealer?',
            html: `Yakin ingin menghapus <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-delete-' + kode).submit(); } });
    }

    function confirmRestore(url, nama) {
        Swal.fire({
            title: 'Pulihkan Dealer?',
            html: `Kembalikan data <strong>${nama}</strong> ke daftar aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#113883', 
            confirmButtonText: 'Ya, Pulihkan!'
        }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
    }

    function confirmForceDelete(kode, nama) {
        Swal.fire({
            title: 'HAPUS PERMANEN?',
            html: `Data <strong>${nama}</strong> akan dihapus selamanya!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-force-' + kode).submit(); } });
    }
</script>
@endpush
@endsection