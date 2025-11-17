@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Tambah Master Posisi</h3>
    <p class="text-muted">Langkah 1: Isi Info Dasar Posisi. Langkah 2: Klik "Atur Kriteria & Skala" di halaman index.</p>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posisi.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="kode_posisi">Kode Posisi</label>
                    <input type="text" class="form-control @error('kode_posisi') is-invalid @enderror" 
                           id="kode_posisi" name="kode_posisi" value="{{ old('kode_posisi') }}">
                    @error('kode_posisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nama_posisi">Nama Posisi</label>
                    <input type="text" class="form-control @error('nama_posisi') is-invalid @enderror" 
                           id="nama_posisi" name="nama_posisi" value="{{ old('nama_posisi') }}">
                    @error('nama_posisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="level">Level</label>
                    <input type="text" class="form-control @error('level') is-invalid @enderror" 
                           id="level" name="level" value="{{ old('level') }}">
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_active">Status</label>
                    <select class="form-control" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.posisi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection