@extends('layouts.public')

@section('title', 'Formulir Seleksi Administrasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h3 class="text-primary fw-bold mb-1">Formulir Seleksi Administrasi</h3>
                    <h5 class="text-muted mb-0">Posisi: {{ $lowongan->posisi->nama_posisi }}</h5>
                    <hr>
                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i> 
                        Silakan jawab pertanyaan di bawah ini dengan jujur sesuai dengan kondisi Anda saat ini. 
                        Jawaban ini akan digunakan sebagai dasar penilaian seleksi administrasi (SAW).
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pelamar.lamaran.store', $lowongan->id_lowongan) }}" method="POST">
                        @csrf

                        @forelse($kriterias as $kriteria)
                            <div class="card mb-4 border rounded-3 shadow-sm">
                                <div class="card-header bg-light fw-bold text-dark">
                                    {{ $loop->iteration }}. {{ $kriteria->nama_kriteria }}
                                </div>
                                <div class="card-body">
                                    @if($kriteria->skalaNilai->isEmpty())
                                        <div class="alert alert-warning small mb-0">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Pilihan jawaban untuk kriteria ini belum diatur oleh Admin.
                                        </div>
                                    @else
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($kriteria->skalaNilai as $skala)
                                                <div class="form-check card-radio p-0 mb-2">
                                                    <input class="form-check-input d-none" type="radio" 
                                                           name="kriteria_{{ $kriteria->id_kriteria }}" 
                                                           id="opsi_{{ $skala->id_skala }}" 
                                                           value="{{ $skala->id_skala }}" 
                                                           required>
                                                    <label class="form-check-label btn btn-outline-secondary w-100 text-start p-3 rounded shadow-sm" 
                                                           for="opsi_{{ $skala->id_skala }}">
                                                        {{ $skala->deskripsi }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Tidak ada kriteria khusus untuk posisi ini. Anda bisa langsung mengirim lamaran.
                            </div>
                        @endforelse

                        <div class="d-grid mt-4 gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Lamaran Saya
                            </button>
                            <a href="{{ route('lowongan.show', $lowongan->id_lowongan) }}" class="btn btn-outline-secondary">Batal</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Style agar Radio Button terlihat seperti tombol pilihan yang rapi */
    .form-check-input:checked + .form-check-label {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .form-check-label:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
        cursor: pointer;
    }
    .form-check-input:checked + .form-check-label:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }
</style>
@endsection