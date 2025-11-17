@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Kriteria</h3>
        <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">+ Tambah Kriteria</a>
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
                        <th>Nama Kriteria</th>
                        <th>Jenis</th>
                        <th>Bobot SAW</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kriterias as $kriteria)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kriteria->nama_kriteria }}</td>
                        <td>{{ $kriteria->jenis }}</td>
                        <td>{{ $kriteria->bobot_saw }}</td>
                        <td>
                            <a href="{{ route('admin.kriteria.edit', $kriteria->id_kriteria) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.kriteria.destroy', $kriteria->id_kriteria) }}"
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
                        <td colspan="5" class="text-center">Data kriteria masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection