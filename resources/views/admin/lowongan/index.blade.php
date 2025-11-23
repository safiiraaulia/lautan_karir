@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Lowongan</h3>
        <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary">+ Tambah Lowongan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Posisi</th>
                        <th>Dealer</th>
                        <th>Tgl Buka</th>
                        <th>Tgl Tutup</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $lowongan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lowongan->posisi->nama_posisi ?? 'N/A' }}</td>
                        <td>{{ $lowongan->dealer->nama_dealer ?? 'N/A' }}</td>
                        <td>{{ $lowongan->tgl_buka->format('d M Y') }}</td>
                        <td>{{ $lowongan->tgl_tutup->format('d M Y') }}</td>
                        <td>
                            @if($lowongan->status == 'Buka' && \Carbon\Carbon::now()->startOfDay()->lte($lowongan->tgl_tutup))
                                <span class="badge bg-success">Buka</span>
                            @else
                                <span class="badge bg-danger">Tutup</span>
                                
                                @if($lowongan->tgl_tutup < \Carbon\Carbon::now()->startOfDay() && $lowongan->status == 'Buka')
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.lowongan.edit', $lowongan->id_lowongan) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.lowongan.destroy', $lowongan->id_lowongan) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data lowongan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection