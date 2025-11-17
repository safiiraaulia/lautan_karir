@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Tambah Kriteria Baru</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kriteria.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="nama_kriteria">Nama Kriteria</label>
                    <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                           id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}">
                    @error('nama_kriteria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jenis">Jenis Kriteria</label>
                    <select class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Benefit" {{ old('jenis') == 'Benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi nilai semakin baik)</option>
                        <option value="Cost" {{ old('jenis') == 'Cost' ? 'selected' : '' }}>Cost (Semakin rendah nilai semakin baik)</option>
                    </select>
                    @error('jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="bobot_saw">Bobot (Tidak Terpakai)</label>
                    <input type="number" step="0.01" class="form-control @error('bobot_saw') is-invalid @enderror" 
                           id="bobot_saw" name="bobot_saw" value="{{ old('bobot_saw', 0) }}">
                    <small class="form-text text-muted">Kolom ini sudah tidak terpakai, bobot (W) diatur di "Master Posisi". Biarkan nilainya 0.</small>
                    @error('bobot_saw')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection