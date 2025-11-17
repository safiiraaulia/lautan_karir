@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Skala Nilai</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.skala-nilai.update', $skalaNilai->id_skala) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="posisi_id">Untuk Posisi</label>
                    <select class="form-control @error('posisi_id') is-invalid @enderror" 
                            id="posisi_id" name="posisi_id">
                        <option value="">-- Pilih Posisi --</option>
                        @foreach($posisis as $posisi)
                            <option value="{{ $posisi->kode_posisi }}" 
                                    {{ old('posisi_id', $skalaNilai->posisi_id) == $posisi->kode_posisi ? 'selected' : '' }}>
                                {{ $posisi->nama_posisi }}
                            </option>
                        @endforeach
                    </select>
                    @error('posisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="kriteria_id">Untuk Kriteria</label>
                    <select class="form-control @error('kriteria_id') is-invalid @enderror" 
                            id="kriteria_id" name="kriteria_id">
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id_kriteria }}" 
                                    {{ old('kriteria_id', $skalaNilai->kriteria_id) == $kriteria->id_kriteria ? 'selected' : '' }}>
                                {{ $kriteria->nama_kriteria }}
                            </option>
                        @endforeach
                    </select>
                    @error('kriteria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi Skala (Contoh: S1, D3, Baik, Cukup)</label>
                    <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" 
                           id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $skalaNilai->deskripsi) }}">
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nilai">Nilai (Bobot Skala)</label>
                    <input type="number" class="form-control @error('nilai') is-invalid @enderror" 
                           id="nilai" name="nilai" value="{{ old('nilai', $skalaNilai->nilai) }}">
                    @error('nilai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.skala-nilai.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection