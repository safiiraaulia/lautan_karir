@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Kriteria' : 'Master Kriteria')

@section('content')
{{-- Tambahan CSS untuk DataTables dan Pengecilan Font --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    .table-custom {
        font-size: 12px; 
    }
    .table-custom th, .table-custom td {
        padding: 8px 10px !important; /* Mengurangi padding agar lebih rapat */
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">
                {{ $isTrash ? 'Data Kriteria Terhapus' : 'Master Kriteria' }}
            </h3>
        </div>

        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary shadow-sm btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary shadow-sm btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Kriteria
                </a>
                <a href="{{ route('admin.kriteria.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm btn-sm">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                {{-- Menggunakan class table-sm dan table-custom untuk tampilan mungil --}}
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="tableKriteria">
                    <thead class="table-dark text-white">
                        <tr>
                            <th width="40" class="no-sort">NO</th>
                            <th width="180">NAMA KRITERIA</th>
                            <th>PERTANYAAN (UNTUK PELAMAR)</th>
                            {{-- Kolom Aksi dimatikan fitur sorting-nya --}}
                            <th width="{{ $isTrash ? '220' : '180' }}" class="text-center no-sort">AKSI</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kriterias as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $row->nama_kriteria }}</td>
                                <td class="text-muted" style="font-size: 11px;">{{ $row->pertanyaan ?? '-' }}</td>

                                <td class="text-center">
                                    @if($isTrash)
                                        <button class="btn btn-success btn-xs px-2 shadow-sm" 
                                                onclick="confirmRestore('{{ route('admin.kriteria.restore', $row->id_kriteria) }}', '{{ $row->nama_kriteria }}')">
                                                 Pulihkan
                                        </button>

                                        <form action="{{ route('admin.kriteria.force-delete', $row->id_kriteria) }}"
                                              method="POST" id="form-force-{{ $row->id_kriteria }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-dark btn-xs px-2 shadow-sm"
                                                    onclick="confirmForceDelete('{{ $row->id_kriteria }}', '{{ $row->nama_kriteria }}')">
                                                     Hapus Permanen
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.kriteria.edit', $row->id_kriteria) }}"
                                           class="btn btn-warning btn-xs shadow-sm px-2">
                                             Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-xs shadow-sm px-2"
                                                onclick="confirmDelete('{{ $row->id_kriteria }}', '{{ $row->nama_kriteria }}')">
                                                 Hapus
                                        </button>

                                        <form id="form-delete-{{ $row->id_kriteria }}" 
                                              action="{{ route('admin.kriteria.destroy', $row->id_kriteria) }}" 
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

@push('scripts')
{{-- Library DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tableKriteria').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": "no-sort" } // Nonaktifkan sorting di kolom NO dan AKSI
            ],
            "pageLength": 10,
            "order": [[ 1, "asc" ]] // Default sort berdasarkan Nama Kriteria
        });
    });

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Kriteria?',
            html: `Yakin ingin menghapus <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-delete-' + id).submit(); } });
    }

    function confirmRestore(url, nama) {
        Swal.fire({
            title: 'Pulihkan Kriteria?',
            html: `Kembalikan <strong>${nama}</strong> ke daftar kriteria aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Ya, Pulihkan!'
        }).then((result) => { if (result.isConfirmed) { window.location.href = url; } });
    }

    function confirmForceDelete(id, nama) {
        Swal.fire({
            title: 'HAPUS PERMANEN?',
            html: `Data <strong>${nama}</strong> akan hilang selamanya!<br><small class="text-danger">Kaitan kriteria pada posisi dan skala nilai juga akan terhapus.</small>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529',
            confirmButtonText: 'Hapus Selamanya!'
        }).then((result) => { if (result.isConfirmed) { document.getElementById('form-force-' + id).submit(); } });
    }
</script>
@endpush
@endsection