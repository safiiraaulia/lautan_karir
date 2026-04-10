@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Posisi' : 'Master Posisi')

@section('content')
{{-- Tambahan CSS untuk DataTables dan Pengecilan Font --}}
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

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">
                {{ $isTrash ? 'Data Posisi Terhapus' : 'Master Posisi' }}
            </h3>
        </div>

        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.posisi.index') }}" class="btn btn-secondary shadow-sm btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.posisi.create') }}" class="btn btn-primary shadow-sm btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Posisi
                </a>
                <a href="{{ route('admin.posisi.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm btn-sm">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    {{-- Card Tabel --}}
    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="tablePosisi">
                    <thead class="table-dark text-white">
                        <tr>
                            <th width="120">KODE POSISI</th>
                            <th>NAMA POSISI</th>
                            <th>LEVEL</th>
                            <th width="{{ $isTrash ? '220' : '230' }}" class="no-sort">AKSI</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($posisis as $row)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $row->kode_posisi }}</td>
                                <td>{{ $row->nama_posisi }}</td>
                                <td class="text-center"> {{ $row->level ?? '-' }}</td>
                                
                                <td class="text-center">
                                    @if($isTrash)
                                        <button type="button" class="btn btn-success btn-xs px-2 shadow-sm"
                                                onclick="confirmRestore('{{ route('admin.posisi.restore', $row->kode_posisi) }}', '{{ $row->nama_posisi }}')">
                                                Pulihkan
                                        </button>

                                        <button type="button" class="btn btn-dark btn-xs px-2 shadow-sm"
                                                onclick="confirmForceDelete('{{ $row->kode_posisi }}', '{{ $row->nama_posisi }}')">
                                                 Hapus Permanen
                                        </button>

                                        <form id="form-force-{{ $row->kode_posisi }}" 
                                              action="{{ route('admin.posisi.force-delete', $row->kode_posisi) }}" 
                                              method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    @else
                                        <a href="{{ route('admin.posisi.setupSaw', $row->kode_posisi) }}"
                                           class="btn btn-info btn-xs shadow-sm px-2" title="Atur Kriteria">
                                            Atur Kriteria
                                        </a>

                                        <a href="{{ route('admin.posisi.edit', $row->kode_posisi) }}"
                                           class="btn btn-warning btn-xs shadow-sm px-2" title="Edit Data">
                                             Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-xs shadow-sm px-2"
                                                onclick="confirmDelete('{{ $row->kode_posisi }}', '{{ $row->nama_posisi }}')">
                                                 Hapus
                                        </button>

                                        <form id="form-delete-{{ $row->kode_posisi }}" 
                                              action="{{ route('admin.posisi.destroy', $row->kode_posisi) }}" 
                                              method="POST" style="display:none;">
                                            @csrf @method('DELETE')
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

{{-- Scripts SweetAlert2 & DataTables --}}
@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablePosisi').DataTable({
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

    // ... (Fungsi SweetAlert tetap sama) ...
    function confirmDelete(kode, nama) {
        Swal.fire({
            title: 'Hapus Posisi?',
            html: `Apakah Anda yakin ingin menghapus posisi <strong>${nama}</strong>?<br>Data akan dipindahkan ke tempat sampah.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b', 
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-delete-' + kode).submit(); } });
    }

    function confirmRestore(url, nama) {
        Swal.fire({
            title: 'Pulihkan Posisi?',
            html: `Kembalikan data <strong>${nama}</strong> ke daftar posisi aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a', 
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Pulihkan!',
            cancelButtonText: 'Batal'
        }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
    }

    function confirmForceDelete(kode, nama) {
        Swal.fire({
            title: 'HAPUS PERMANEN?',
            html: `Anda akan menghapus posisi <strong>${nama}</strong> selamanya.<br><small class="text-danger">PERINGATAN: Menghapus permanen akan menghilangkan data kriteria terkait!</small>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529', 
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Hapus Selamanya!',
            cancelButtonText: 'Batal',
            focusCancel: true
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-force-' + kode).submit(); } });
    }
</script>
@endpush
@endsection