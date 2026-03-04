@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Lowongan' : 'Kelola Lowongan')

@section('content')
<div class="container-fluid mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">{{ $isTrash ? 'Data Lowongan Terhapus' : 'Kelola Lowongan' }}</h3>
        </div>
        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary shadow-sm px-3">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary shadow-sm px-3">
                    <i class="fas fa-plus mr-1"></i> Tambah Lowongan
                </a>
                <a href="{{ route('admin.lowongan.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm px-3">
                    <i class="fas fa-trash-restore mr-1"></i> Lihat Data Terhapus
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4 {{ $isTrash ? 'border-left-danger' : 'border-left-primary' }}">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 align-middle">
                    <thead class="table-dark text-white text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Posisi</th>
                            <th>Dealer</th>
                            <th>Tgl Buka</th>
                            <th>Tgl Tutup</th>
                            <th>Status</th>
                            <th width="{{ $isTrash ? '250' : '200' }}">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowongans as $lowongan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $lowongan->posisi->nama_posisi ?? 'N/A' }}</td>
                                <td>{{ $lowongan->dealer->nama_dealer ?? 'N/A' }}</td>
                                <td class="text-center small">{{ $lowongan->tgl_buka->format('d M Y') }}</td>
                                <td class="text-center small">{{ $lowongan->tgl_tutup->format('d M Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $isExpired = \Carbon\Carbon::now()->startOfDay()->gt($lowongan->tgl_tutup);
                                    @endphp

                                    @if($lowongan->status == 'Buka' && !$isExpired)
                                        <span class="badge bg-success shadow-sm">Buka</span>
                                    @else
                                        <span class="badge bg-danger shadow-sm">Tutup</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($isTrash)
                                        <button class="btn btn-success btn-sm px-1 shadow-sm" onclick="confirmRestore('{{ route('admin.lowongan.restore', $lowongan->id_lowongan) }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Pulihkan
                                        </button>
                                        <button class="btn btn-dark btn-sm px-2 shadow-sm" onclick="confirmForceDelete('{{ $lowongan->id_lowongan }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Hapus Permanen
                                        </button>
                                        <form id="form-force-{{ $lowongan->id_lowongan }}" action="{{ route('admin.lowongan.force-delete', $lowongan->id_lowongan) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
                                    @else
                                        <a href="{{ route('admin.lowongan.edit', $lowongan->id_lowongan) }}" class="btn btn-warning btn-sm shadow-sm">
                                             Edit
                                        </a>
                                        <button class="btn btn-danger btn-sm shadow-sm" onclick="confirmDelete('{{ $lowongan->id_lowongan }}', '{{ $lowongan->posisi->nama_posisi }}')">
                                             Hapus
                                        </button>
                                        <form id="form-delete-{{ $lowongan->id_lowongan }}" action="{{ route('admin.lowongan.destroy', $lowongan->id_lowongan) }}" method="POST" style="display:none;">@csrf @method('DELETE')</form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-5">Belum ada data lowongan.</td></tr>
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