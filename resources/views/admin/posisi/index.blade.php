@extends('layouts.admin')

@section('title', 'Master Posisi')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Posisi</h3>
        <a href="{{ route('admin.posisi.create') }}" class="btn btn-primary">+ Tambah Posisi</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Posisi</th>
                        <th>Level</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posisi as $row)
                        <tr>
                            <td>{{ $row->id_posisi }}</td>
                            <td>{{ $row->nama_posisi }}</td>
                            <td>{{ $row->level ?? '-' }}</td>

                            <td>
                                <a href="{{ route('admin.posisi.edit', $row->id_posisi) }}"
                                   class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.posisi.destroy', $row->id_posisi) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus posisi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
