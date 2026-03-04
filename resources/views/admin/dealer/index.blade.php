@extends('layouts.admin')

@section('title', $isTrash ? 'Data Terhapus - Dealer' : 'Master Dealer')

@section('content')
<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">
                {{ $isTrash ? 'Data Dealer Terhapus' : 'Master Dealer' }}
            </h3>
        </div>

        <div class="d-flex" style="gap: 10px;">
            @if($isTrash)
                <a href="{{ route('admin.dealer.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            @else
                <a href="{{ route('admin.dealer.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Dealer
                </a>
                <a href="{{ route('admin.dealer.index', ['trash' => 1]) }}" class="btn btn-outline-danger shadow-sm">
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
                            <th width="150">KODE DEALER</th>
                            <th>NAMA DEALER</th>
                            <th>KOTA</th>
                            <th>SINGKATAN</th>
                            <th width="{{ $isTrash ? '220' : '180' }}">AKSI</th> 
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
                                        {{-- Mode Trash --}}
                                        <button class="btn btn-success btn-sm px-1 shadow-sm" 
                                                onclick="confirmRestore('{{ route('admin.dealer.restore', $row->kode_dealer) }}', '{{ $row->nama_dealer }}')">
                                             Pulihkan
                                        </button>

                                        <form action="{{ route('admin.dealer.force-delete', $row->kode_dealer) }}"
                                              method="POST" id="form-force-{{ $row->kode_dealer }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-dark btn-sm px-1 shadow-sm"
                                                    onclick="confirmForceDelete('{{ $row->kode_dealer }}', '{{ $row->nama_dealer }}')">
                                                    Hapus Permanen
                                            </button>
                                        </form>
                                    @else
                                        {{-- Mode Aktif --}}
                                        <a href="{{ route('admin.dealer.edit', $row->kode_dealer) }}"
                                           class="btn btn-warning btn-sm shadow-sm">
                                             Edit
                                        </a>

                                        <form action="{{ route('admin.dealer.destroy', $row->kode_dealer) }}"
                                              method="POST" id="form-delete-{{ $row->kode_dealer }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm shadow-sm"
                                                    onclick="confirmDelete('{{ $row->kode_dealer }}', '{{ $row->nama_dealer }}')">
                                                     Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isTrash ? '5' : '5' }}" class="text-center text-muted py-5">
                                    {{ $isTrash ? 'Tidak ada data dealer terhapus.' : 'Belum ada data dealer aktif.' }}
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
    function confirmDelete(kode, nama) {
        Swal.fire({
            title: 'Hapus Dealer?',
            html: `Yakin ingin menghapus <strong>${nama}</strong>? Data akan dipindahkan ke tempat sampah.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
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
            title: 'Pulihkan Dealer?',
            html: `Kembalikan data <strong>${nama}</strong> ke daftar aktif?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
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
            html: `Anda akan menghapus <strong>${nama}</strong> selamanya. Tindakan ini tidak bisa dibatalkan!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#212529',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-force-' + kode).submit();
            }
        });
    }
</script>
@endpush
@endsection