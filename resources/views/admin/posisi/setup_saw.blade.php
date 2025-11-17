@extends('layouts.admin')

@section('title', 'Setup SAW: ' . $posisi->nama_posisi)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Atur Kriteria & Skala SAW</h3>
        <a href="{{ route('admin.posisi.index') }}" class="btn btn-secondary">Kembali ke Daftar Posisi</a>
    </div>

    <h4>Posisi: {{ $posisi->nama_posisi }} ({{ $posisi->kode_posisi }})</h4>
    <p class="text-muted">Atur Bobot (W) Kriteria dan Nilai Skala (Cij) sekaligus di halaman ini.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posisi.storeSaw', $posisi->kode_posisi) }}" method="POST">
                @csrf
                
                <p class="text-danger small"><strong>PENTING:</strong> Pastikan total Bobot (W) yang Anda masukkan mendekati atau sama dengan 1 (atau 100%).</p>

                <div id="kriteria-list">
                    @forelse ($kriterias as $index => $kriteria)
                        @php
                            // Cek data tersimpan dari Controller (PosisiController@setupSaw)
                            $isChecked = array_key_exists($kriteria->id_kriteria, $bobot_tersimpan);
                            $oldBobot = $bobot_tersimpan[$kriteria->id_kriteria] ?? 0;
                            
                            // Ambil skala tersimpan untuk kriteria ini
                            $skalas = $skala_tersimpan[$kriteria->id_kriteria] ?? [];
                        @endphp

                        <div class="card mb-4 border-primary shadow-sm" id="kriteria-card-{{ $kriteria->id_kriteria }}">
                            <div class="card-header bg-primary text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kriteria[{{ $kriteria->id_kriteria }}][id]" 
                                                   value="{{ $kriteria->id_kriteria }}" id="kriteria-{{ $kriteria->id_kriteria }}"
                                                   onchange="toggleSkalaInput({{ $kriteria->id_kriteria }})"
                                                   {{ $isChecked ? 'checked' : '' }}>
                                            <label class="form-check-label h5 mb-0" for="kriteria-{{ $kriteria->id_kriteria }}">
                                                {{ $kriteria->nama_kriteria }} ({{ $kriteria->jenis }})
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <span class="input-group-text">Bobot (W):</span>
                                            <input type="number" step="0.01" min="0" max="1" 
                                                   class="form-control bobot-input @error('kriteria.' . $kriteria->id_kriteria . '.bobot') is-invalid @enderror" 
                                                   name="kriteria[{{ $kriteria->id_kriteria }}][bobot]" placeholder="Contoh: 0.4"
                                                   value="{{ old('kriteria.' . $kriteria->id_kriteria . '.bobot', $oldBobot) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border-top" id="skala-container-{{ $kriteria->id_kriteria }}" style="display: {{ $isChecked ? 'block' : 'none' }};">
                                <h6>Nilai Skala (Cij) untuk Kriteria Ini:</h6>
                                
                                <div class="skala-wrapper">
                                    
                                    @forelse($skalas as $skala)
                                        <div class="row mb-2 skala-row">
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="skala[{{ $kriteria->id_kriteria }}][skala_{{ $loop->index }}][deskripsi]" placeholder="Deskripsi (S1, D3, dll)" value="{{ $skala->deskripsi }}">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="skala[{{ $kriteria->id_kriteria }}][skala_{{ $loop->index }}][nilai]" placeholder="Nilai (1-5)" value="{{ $skala->nilai }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeSkala(this)">Hapus</button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row mb-2 skala-row">
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="skala[{{ $kriteria->id_kriteria }}][skala_0][deskripsi]" placeholder="Deskripsi (S1, D3, dll)" value="">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="skala[{{ $kriteria->id_kriteria }}][skala_0][nilai]" placeholder="Nilai (1-5)" value="">
                                            </div>
                                            <div class="col-md-2">
                                                </div>
                                        </div>
                                    @endforelse

                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addSkalaRow({{ $kriteria->id_kriteria }})">
                                    + Tambah Skala Nilai
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">Belum ada Kriteria yang terdaftar. Silakan isi Master Kriteria terlebih dahulu.</div>
                    @endforelse
                </div>

                <hr>
                <button type="submit" class="btn btn-success btn-lg">Simpan Pengaturan SAW</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Fungsi untuk menyembunyikan/menampilkan form Skala Nilai
    function toggleSkalaInput(kriteriaId) {
        const checkbox = document.getElementById(`kriteria-${kriteriaId}`);
        const container = document.getElementById(`skala-container-${kriteriaId}`);
        const bobotInput = container.closest('.card').querySelector('.bobot-input');

        if (checkbox.checked) {
            container.style.display = 'block';
            bobotInput.setAttribute('required', 'required'); // Wajib isi bobot
        } else {
            container.style.display = 'none';
            bobotInput.removeAttribute('required');
            bobotInput.value = 0; // Set bobot menjadi 0 jika tidak dicentang
        }
    }

    // Fungsi untuk menambah baris Skala Nilai secara dinamis
    function addSkalaRow(kriteriaId) {
        const container = document.getElementById(`skala-container-${kriteriaId}`);
        const wrapper = container.querySelector('.skala-wrapper');
        
        // Hitung index baru untuk array skala
        const rowCount = wrapper.querySelectorAll('.skala-row').length;
        const newIndex = rowCount; // Gunakan rowCount sebagai index baru (misal: skala_0, skala_1, ...)

        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 skala-row';
        newRow.innerHTML = `
            <div class="col-md-7">
                <input type="text" class="form-control" name="skala[${kriteriaId}][skala_${newIndex}][deskripsi]" placeholder="Deskripsi (S1, D3, dll)" value="">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="skala[${kriteriaId}][skala_${newIndex}][nilai]" placeholder="Nilai (1-5)" value="">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeSkala(this)">Hapus</button>
            </div>
        `;
        wrapper.appendChild(newRow);
    }

    // Fungsi untuk menghapus baris Skala Nilai
    function removeSkala(button) {
        const row = button.closest('.skala-row');
        row.remove();
    }

    // Panggil fungsi toggle saat halaman dimuat untuk memastikan status Bobot sudah benar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            toggleSkalaInput(checkbox.value);
        });
    });
</script>
@endsection