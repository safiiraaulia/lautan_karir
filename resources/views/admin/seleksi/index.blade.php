@extends('layouts.admin')

@section('title', 'Seleksi Administrasi')

@section('content')
<div class="container mt-4">
    <h3>Seleksi & Perangkingan SAW</h3>
    <p class="text-muted">Pilih lowongan untuk melihat hasil perhitungan SAW (Perangkingan) dari pelamar yang telah mengisi form administrasi.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Posisi</th>
                        <th>Dealer</th>
                        <th>Tgl Tutup</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $lowongan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lowongan->posisi->nama_posisi ?? 'N/A' }}</td>
                        <td>{{ $lowongan->dealer->nama_dealer ?? 'N/A' }}</td>
                        <td>{{ $lowongan->tgl_tutup->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.seleksi.show', $lowongan->id_lowongan) }}" class="btn btn-primary btn-sm">
                                Lihat Hasil SAW
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada lowongan yang sedang dibuka atau memiliki pelamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection