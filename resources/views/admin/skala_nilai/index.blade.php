@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Skala Nilai</h3>
        <a href="{{ route('admin.skala-nilai.create') }}" class="btn btn-primary">+ Tambah Skala Nilai</a>
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
                        <th>Posisi</th> <th>Kriteria</th>
                        <th>Deskripsi Skala</th>
                        <th>Nilai</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($skalaNilais as $skala)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $skala->posisi->nama_posisi ?? 'Posisi Dihapus' }}</td> 
                        <td>{{ $skala->kriteria->nama_kriteria ?? 'Kriteria Dihapus' }}</td>
                        <td>{{ $skala->deskripsi }}</td>
                        <td>{{ $skala->nilai }}</td>
                        <td>
                            <a href="{{ route('admin.skala-nilai.edit', $skala->id_skala) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.skala-nilai.destroy', $skala->id_skala) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data skala nilai masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection