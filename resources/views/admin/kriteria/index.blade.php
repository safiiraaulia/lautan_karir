@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Kriteria' : 'Master Kriteria')

@section('content')
<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">
                {{ $isTrash ? 'Data Kriteria Terhapus' : 'Master Kriteria' }}
            </h3>
        </div>

        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Kriteria
                </a>
                <a href="{{ route('admin.kriteria.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 align-middle">
                    <thead class="table-dark text-white">
                        <tr>
                            <th width="50" class="text-center">NO</th>
                            <th width="200">NAMA KRITERIA</th>
                            <th>PERTANYAAN (UNTUK PELAMAR)</th>
                            <th width="{{ $isTrash ? '300' : '250' }}" class="text-center">AKSI</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kriterias as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $row->nama_kriteria }}</td>
                                <td class="text-muted small">{{ $row->pertanyaan ?? '-' }}</td>

                                <td class="text-center">
                                    @if($isTrash)
                                        <button class="btn btn-success btn-sm px-3 shadow-sm" 
                                                onclick="confirmRestore('{{ route('admin.kriteria.restore', $row->id_kriteria) }}', '{{ $row->nama_kriteria }}')">
                                                 Pulihkan
                                        </button>

                                        <form action="{{ route('admin.kriteria.force-delete', $row->id_kriteria) }}"
                                              method="POST" id="form-force-{{ $row->id_kriteria }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-dark btn-sm px-3 shadow-sm"
                                                    onclick="confirmForceDelete('{{ $row->id_kriteria }}', '{{ $row->nama_kriteria }}')">
                                                     Hapus Permanen
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.kriteria.edit', $row->id_kriteria) }}"
                                           class="btn btn-warning btn-sm shadow-sm">
                                             Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm shadow-sm"
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
                            <tr>
                                <td colspan="{{ $isTrash ? '5' : '4' }}" class="text-center text-muted py-5">
                                    {{ $isTrash ? 'Tidak ada kriteria di tempat sampah.' : 'Belum ada data kriteria aktif.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Kriteria?',
            html: `Yakin ingin menghapus <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }

    function confirmRestore(url, nama) {
        Swal.fire({
            title: 'Pulihkan Kriteria?',
            html: `Kembalikan <strong>${nama}</strong> ke daftar kriteria aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Ya, Pulihkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function confirmForceDelete(id, nama) {
        Swal.fire({
            title: 'HAPUS PERMANEN?',
            html: `Data <strong>${nama}</strong> akan hilang selamanya!<br><small class="text-danger">Kaitan kriteria pada posisi dan skala nilai juga akan terhapus.</small>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529',
            confirmButtonText: 'Hapus Selamanya!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-force-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection