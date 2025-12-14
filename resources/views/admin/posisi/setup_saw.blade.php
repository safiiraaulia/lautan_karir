@extends('layouts.admin')

@section('title', 'Setup SAW: ' . $posisi->nama_posisi)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-primary mb-0">Setup Bobot & Kriteria</h3>
            <p class="text-muted small mb-0">Posisi: <strong>{{ $posisi->nama_posisi }}</strong> ({{ $posisi->kode_posisi }})</p>
        </div>
        <a href="{{ route('admin.posisi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('admin.posisi.storeSaw', $posisi->kode_posisi) }}" method="POST">
        @csrf
        
        <div class="alert alert-info d-flex align-items-center border-0 shadow-sm mb-4">
            <i class="fas fa-info-circle fa-2x me-3"></i>
            <div>
                <strong>Aturan Pengisian:</strong>
                <ul class="mb-0 small ps-3">
                    <li>Centang kriteria yang dibutuhkan untuk posisi ini.</li>
                    <li>Total <strong>Bobot (W)</strong> dari semua kriteria yang dicentang harus berjumlah <strong>1</strong> (Contoh: 0.5 + 0.3 + 0.2 = 1).</li>
                    <li>Isi <strong>Syarat</strong> dengan jelas (Contoh: "Min. S1" atau "Memiliki SIM C").</li>
                </ul>
            </div>
        </div>

        <div class="row">
            @forelse ($kriterias as $kriteria)
                @php
                    // Ambil data yang tersimpan di database (jika ada)
                    $dataPivot = $pivot_tersimpan[$kriteria->id_kriteria] ?? null;
                    
                    // Logika checked: Jika ada di DB atau jika sedang ada input old (saat error validasi)
                    $isChecked = old('kriteria.'.$kriteria->id_kriteria.'.id', $dataPivot ? true : false);
                    
                    $oldBobot  = old('kriteria.'.$kriteria->id_kriteria.'.bobot', $dataPivot['bobot'] ?? '');
                    $oldSyarat = old('kriteria.'.$kriteria->id_kriteria.'.syarat', $dataPivot['syarat'] ?? '');
                    
                    $skalas = $skala_tersimpan[$kriteria->id_kriteria] ?? [];
                @endphp

                <div class="col-12 mb-3">
                    <div class="card border shadow-sm {{ $isChecked ? 'border-primary' : 'border-light' }}" id="card-{{ $kriteria->id_kriteria }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                
                                <div class="col-md-4 mb-2 mb-md-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="kriteria[{{ $kriteria->id_kriteria }}][id]" 
                                               value="{{ $kriteria->id_kriteria }}" 
                                               id="kriteria-{{ $kriteria->id_kriteria }}"
                                               onchange="toggleActive({{ $kriteria->id_kriteria }})"
                                               {{ $isChecked ? 'checked' : '' }}
                                               style="transform: scale(1.2); cursor: pointer;">
                                        
                                        <label class="form-check-label fw-bold ms-2 cursor-pointer" for="kriteria-{{ $kriteria->id_kriteria }}" style="font-size: 1.1rem;">
                                            {{ $kriteria->nama_kriteria }}
                                        </label>
                                        <div class="ms-4">
                                            <span class="badge {{ $kriteria->jenis == 'Benefit' ? 'bg-success' : 'bg-danger' }} text-white" style="font-size: 0.7rem;">
                                                {{ $kriteria->jenis }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2 mb-md-0 input-area-{{ $kriteria->id_kriteria }}" style="{{ $isChecked ? '' : 'opacity: 0.5; pointer-events: none;' }}">
                                    <label class="small text-muted fw-bold">Bobot (W)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" max="1" 
                                               class="form-control bobot-input fw-bold text-center text-primary" 
                                               name="kriteria[{{ $kriteria->id_kriteria }}][bobot]" 
                                               placeholder="0.0"
                                               value="{{ $oldBobot }}">
                                    </div>
                                    <small class="text-muted" style="font-size: 10px;">Desimal (Cth: 0.25)</small>
                                </div>

                                <div class="col-md-5 input-area-{{ $kriteria->id_kriteria }}" style="{{ $isChecked ? '' : 'opacity: 0.5; pointer-events: none;' }}">
                                    <label class="small text-muted fw-bold">Syarat / Kualifikasi</label>
                                    <input type="text" 
                                           class="form-control syarat-input" 
                                           name="kriteria[{{ $kriteria->id_kriteria }}][syarat]" 
                                           placeholder="Cth: Min. S1 Sistem Informasi"
                                           value="{{ $oldSyarat }}">
                                </div>
                            </div>
                            
                            <div class="mt-3 pt-3 border-top skala-container" id="skala-box-{{ $kriteria->id_kriteria }}" style="display: {{ $isChecked ? 'block' : 'none' }}">
                                <h6 class="text-primary small fw-bold mb-3"><i class="fas fa-list-ol me-1"></i> Atur Nilai Sub-Kriteria (Skala):</h6>
                                
                                <div class="skala-wrapper bg-light p-3 rounded">
                                    @forelse($skalas as $index => $skala)
                                        <div class="row mb-2 skala-row align-items-center">
                                            <div class="col-8">
                                                <input type="text" class="form-control form-control-sm bg-white" name="skala[{{ $kriteria->id_kriteria }}][{{ $index }}][deskripsi]" placeholder="Deskripsi (Mis: IPK > 3.0)" value="{{ $skala->deskripsi }}">
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control form-control-sm bg-white text-center fw-bold" name="skala[{{ $kriteria->id_kriteria }}][{{ $index }}][nilai]" placeholder="Nilai" value="{{ $skala->nilai }}" min="1" max="5" oninput="validateMax(this)">
                                            </div>
                                            <div class="col-1 text-end">
                                                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeSkala(this)"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row mb-2 skala-row align-items-center">
                                            <div class="col-8">
                                                <input type="text" class="form-control form-control-sm bg-white" name="skala[{{ $kriteria->id_kriteria }}][0][deskripsi]" placeholder="Deskripsi (Mis: IPK > 3.0)" value="">
                                            </div>
                                            <div class="col-3">
                                                <input type="number" class="form-control form-control-sm bg-white text-center fw-bold" name="skala[{{ $kriteria->id_kriteria }}][0][nilai]" placeholder="Nilai" value="" min="1" max="5" oninput="validateMax(this)">
                                            </div>
                                            <div class="col-1 text-end">
                                                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeSkala(this)"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addSkalaRow({{ $kriteria->id_kriteria }})">
                                        <i class="fas fa-plus me-1"></i> Tambah Baris Skala
                                    </button>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-50">
                    <p class="text-muted">Belum ada Master Kriteria.</p>
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-primary btn-sm">Buat Kriteria Dulu</a>
                </div>
            @endforelse
        </div>

        <div class="card sticky-bottom border-top shadow mt-3">
            <div class="card-body d-flex justify-content-between align-items-center bg-white">
                <div>
                    <span class="text-muted small">Total Bobot Saat Ini:</span>
                    <h4 class="mb-0 fw-bold text-primary" id="displayTotal">0</h4>
                </div>
                <button type="submit" class="btn btn-success btn-lg px-5 shadow fw-bold">
                    <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function validateMax(input) {
        if (input.value > 5) input.value = 5;
        if (input.value < 1 && input.value !== "") input.value = 1;
    }

    function toggleActive(id) {
        const checkbox = document.getElementById(`kriteria-${id}`);
        const inputs = document.querySelectorAll(`.input-area-${id}`);
        const skalaBox = document.getElementById(`skala-box-${id}`);
        const card = document.getElementById(`card-${id}`);

        if (checkbox.checked) {
            inputs.forEach(el => {
                el.style.opacity = '1';
                el.style.pointerEvents = 'auto';
            });
            skalaBox.style.display = 'block';
            card.classList.remove('border-light');
            card.classList.add('border-primary');
            
            // Auto focus ke bobot
            document.querySelector(`input[name="kriteria[${id}][bobot]"]`).focus();
        } else {
            inputs.forEach(el => {
                el.style.opacity = '0.5';
                el.style.pointerEvents = 'none';
            });
            skalaBox.style.display = 'none';
            card.classList.remove('border-primary');
            card.classList.add('border-light');
            
            // Reset nilai
            document.querySelector(`input[name="kriteria[${id}][bobot]"]`).value = '';
            // Jangan reset syarat jika user tidak sengaja uncheck, biarkan saja
            calculateTotal();
        }
    }

    function addSkalaRow(id) {
        const wrapper = document.querySelector(`#skala-box-${id} .skala-wrapper`);
        const newIndex = Date.now();
        const row = `
            <div class="row mb-2 skala-row align-items-center fade-in">
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm bg-white" name="skala[${id}][${newIndex}][deskripsi]" placeholder="Deskripsi" value="">
                </div>
                <div class="col-3">
                    <input type="number" class="form-control form-control-sm bg-white text-center fw-bold" name="skala[${id}][${newIndex}][nilai]" placeholder="Nilai" value="" min="1" max="5" oninput="validateMax(this)">
                </div>
                <div class="col-1 text-end">
                    <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="removeSkala(this)"><i class="fas fa-times-circle"></i></button>
                </div>
            </div>`;
        wrapper.insertAdjacentHTML('beforeend', row);
    }

    function removeSkala(btn) {
        btn.closest('.skala-row').remove();
    }

    // Hitung Total Bobot Real-time
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.bobot-input').forEach(input => {
            if (!input.closest('.input-area-' + input.name.match(/\d+/)[0]).style.pointerEvents.includes('none')) {
                total += parseFloat(input.value || 0);
            }
        });
        const display = document.getElementById('displayTotal');
        display.innerText = total.toFixed(2);
        
        if(Math.abs(total - 1) < 0.001) {
            display.classList.remove('text-danger');
            display.classList.add('text-success');
        } else {
            display.classList.remove('text-success');
            display.classList.add('text-danger');
        }
    }

    // Event Listener untuk hitung total
    document.querySelectorAll('.bobot-input').forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Jalankan hitung total saat load
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    .fade-in { animation: fadeIn 0.3s ease-in; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .sticky-bottom { position: sticky; bottom: 20px; z-index: 100; }
</style>
@endsection