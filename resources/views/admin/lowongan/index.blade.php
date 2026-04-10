@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Lowongan' : 'Kelola Lowongan')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">{{ $isTrash ? 'Data Lowongan Terhapus' : 'Kelola Lowongan' }}</h3>
        </div>
        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary shadow-sm btn-sm px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary shadow-sm btn-sm px-3">
                    <i class="fas fa-plus mr-1"></i> Tambah Lowongan
                </a>
                <a href="{{ route('admin.lowongan.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm btn-sm px-3">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                {{-- Menggunakan class table-sm dan table-custom untuk tampilan mungil --}}
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="lowonganTable">
                    <thead class="table-dark text-white">
                        <tr>
                            <th width="40" class="no-sort">No</th>
                            <th>Posisi</th>
                            <th>Dealer</th>
                            <th width="100">Tgl Buka</th>
                            <th width="100">Tgl Tutup</th>
                            <th width="80">Status</th>
                            <th width="{{ $isTrash ? '200' : '150' }}" class="no-sort">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowongans as $lowongan)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $lowongan->posisi->nama_posisi ?? 'N/A' }}</td>
                                <td>{{ $lowongan->dealer->nama_dealer ?? 'N/A' }}</td>
                                <td class="text-center small">{{ $lowongan->tgl_buka->format('d M Y') }}</td>
                                <td class="text-center small">{{ $lowongan->tgl_tutup->format('d M Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $isExpired = \Carbon\Carbon::now()->startOfDay()->gt($lowongan->tgl_tutup);
                                    @endphp

                                    @if($lowongan->status == 'Buka' && !$isExpired)
                                        <span class="badge bg-success shadow-sm" style="font-size: 10px;">Buka</span>
                                    @else
                                        <span class="badge bg-danger shadow-sm" style="font-size: 10px;">Tutup</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($isTrash)
                                        <button class="btn btn-success btn-xs px-2 shadow-sm" onclick="confirmRestore('{{ route('admin.lowongan.restore', $lowongan->id_lowongan) }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Pulihkan
                                        </button>
                                        <button class="btn btn-dark btn-xs px-2 shadow-sm" onclick="confirmForceDelete('{{ $lowongan->id_lowongan }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Hapus
                                        </button>
                                        <form id="form-force-{{ $lowongan->id_lowongan }}" action="{{ route('admin.lowongan.force-delete', $lowongan->id_lowongan) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
                                    @else
                                        <a href="{{ route('admin.lowongan.edit', $lowongan->id_lowongan) }}" class="btn btn-warning btn-xs shadow-sm px-2">
                                             Edit
                                        </a>
                                        <button class="btn btn-danger btn-xs shadow-sm px-2" onclick="confirmDelete('{{ $lowongan->id_lowongan }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Hapus
                                        </button>
                                        <form id="form-delete-{{ $lowongan->id_lowongan }}" action="{{ route('admin.lowongan.destroy', $lowongan->id_lowongan) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
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
        // Inisialisasi DataTables dengan pengurutan otomatis
        $('#lowonganTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": "no-sort" } // Matikan sorting di kolom No dan Aksi
            ],
            "pageLength": 10,
            "order": [[ 1, "asc" ]] // Urutkan berdasarkan Nama Posisi secara default
        });
    });

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Lowongan?',
            html: `Yakin ingin menghapus lowongan <strong>${nama}</strong>? Data akan dipindahkan ke tempat sampah.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true
        }).then((result) => { if (result.isConfirmed) document.getElementById('form-delete-' + id).submit(); });
    }

    function confirmRestore(url, nama) {
        Swal.fire({
            title: 'Pulihkan?',
            html: `Kembalikan lowongan <strong>${nama}</strong> ke daftar aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Ya, Pulihkan!'
        }).then((result) => { if (result.isConfirmed) window.location.href = url; });
    }

    function confirmForceDelete(id, nama) {
        Swal.fire({
            title: 'HAPUS PERMANEN?',
            html: `Lowongan <strong>${nama}</strong> akan dihapus selamanya. Tindakan ini tidak bisa dibatalkan!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => { if (result.isConfirmed) document.getElementById('form-force-' + id).submit(); });
    }
</script>
@endpush
@endsection