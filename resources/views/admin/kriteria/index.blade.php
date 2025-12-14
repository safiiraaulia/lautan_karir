@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Kriteria</h3>
        <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">+ Tambah Kriteria</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">No</th>
                            <th width="20%">Nama Kriteria</th>
                            <th>Pertanyaan (Untuk Pelamar)</th>
                            <th width="150">Jenis</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kriterias as $kriteria)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            
                            <td>{{ $kriteria->nama_kriteria }}</td>
                            
                            <td class="text-muted small">
                                {{ $kriteria->pertanyaan ?? '-' }}
                            </td>
                            
                            <td>
                                <span class="badge {{ $kriteria->jenis == 'Benefit' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $kriteria->jenis }}
                                </span>
                            </td>
                            
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
                            <td colspan="5" class="text-center py-4 text-muted">
                                Data kriteria masih kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection