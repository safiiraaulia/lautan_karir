@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Posisi' : 'Master Posisi')

@section('content')
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
                <a href="{{ route('admin.posisi.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.posisi.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Posisi
                </a>
                <a href="{{ route('admin.posisi.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm">
                    <i class="fas fa-trash-restore"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    {{-- Card Tabel --}}
    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 align-middle" id="tablePosisi">
                    <thead class="table-dark text-white text-center">
                        <tr>
                            <th width="150">KODE POSISI</th>
                            <th>NAMA POSISI</th>
                            <th>LEVEL</th>
                            <th width="{{ $isTrash ? '350' : '250' }}" class="text-center">AKSI</th> 
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
                                        <button type="button" class="btn btn-success btn-sm px-3 shadow-sm"
                                                onclick="confirmRestore('{{ route('admin.posisi.restore', $row->kode_posisi) }}', '{{ $row->nama_posisi }}')">
                                                Pulihkan
                                        </button>

                                        <button type="button" class="btn btn-dark btn-sm px-3 shadow-sm"
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
                                           class="btn btn-info btn-sm shadow-sm" title="Atur Kriteria">
                                            Atur Kriteria
                                        </a>

                                        <a href="{{ route('admin.posisi.edit', $row->kode_posisi) }}"
                                           class="btn btn-warning btn-sm shadow-sm" title="Edit Data">
                                             Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm shadow-sm"
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
                            <tr>
                                <td colspan="{{ $isTrash ? '4' : '4' }}" class="text-center text-muted py-5">
                                    {{ $isTrash ? 'Tidak ada data posisi terhapus.' : 'Belum ada data posisi aktif.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Scripts SweetAlert2 --}}
@push('scripts')
<script>
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
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + kode).submit();
            }
        });
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
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
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
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-force-' + kode).submit();
            }
        });
    }
</script>
@endpush
@endsection