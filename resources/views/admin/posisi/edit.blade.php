@extends('admin.layout')

@section('title', 'Edit Posisi')

@section('content')
<div class="container mt-4">

    <h3>Edit Posisi</h3>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('admin.posisi.update', $posisi->id_posisi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Posisi</label>
                    <input type="text" name="nama_posisi" class="form-control" 
                           value="{{ $posisi->nama_posisi }}" required>
                    @error('nama_posisi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Level (Opsional)</label>
                    <input type="text" name="level" class="form-control" 
                           value="{{ $posisi->level }}">
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('admin.posisi.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
