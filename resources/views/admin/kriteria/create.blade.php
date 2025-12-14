@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Tambah Kriteria Baru</h3>
        <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.kriteria.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="nama_kriteria" class="form-label fw-bold">Nama Kriteria</label>
                    <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                           id="nama_kriteria" name="nama_kriteria" 
                           value="{{ old('nama_kriteria') }}" 
                           placeholder="Contoh: Pendidikan, Pengalaman, Skill">
                    @error('nama_kriteria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pertanyaan" class="form-label fw-bold">Pertanyaan untuk Pelamar</label>
                    <input type="text" class="form-control @error('pertanyaan') is-invalid @enderror" 
                           id="pertanyaan" name="pertanyaan" 
                           value="{{ old('pertanyaan') }}" 
                           placeholder="Contoh: Apa pendidikan terakhir Anda?">
                    <div class="form-text text-muted">
                        Kalimat tanya ini akan muncul secara otomatis di formulir saat pelamar melamar kerja.
                    </div>
                    @error('pertanyaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis" class="form-label fw-bold">Jenis Kriteria (Sifat SAW)</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Benefit" {{ old('jenis') == 'Benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi nilai, semakin bagus)</option>
                        <option value="Cost" {{ old('jenis') == 'Cost' ? 'selected' : '' }}>Cost (Semakin rendah nilai, semakin bagus)</option>
                    </select>
                    <div class="form-text text-muted small">
                        <ul>
                            <li><strong>Benefit:</strong> Contoh: Pendidikan, Pengalaman, Skill.</li>
                            <li><strong>Cost:</strong> Contoh: Gaji yang diminta (Perusahaan lebih suka gaji kecil/standar).</li>
                        </ul>
                    </div>
                    @error('jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Batal</a>

            </form>
        </div>
    </div>
</div>
@endsection