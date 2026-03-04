@extends('layouts.admin')

@section('title', 'Setup SAW: ' . $posisi->nama_posisi)

@section('content')
<div class="container mt-4 mb-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Setup Bobot & Kriteria</h4>
            <small class="text-muted">Posisi: {{ $posisi->nama_posisi }} ({{ $posisi->kode_posisi }})</small>
        </div>
        <a href="{{ route('admin.posisi.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.posisi.storeSaw', $posisi->kode_posisi) }}" method="POST">
        @csrf

        {{-- Info --}}
        <div class="alert alert-light border small">
            <ul class="mb-0 ps-3">
                <li>Pilih kriteria yang digunakan</li>
                <li>Total bobot harus bernilai <strong>1</strong></li>
                <li>Isi syarat secara singkat & jelas</li>
            </ul>
        </div>

        {{-- Kriteria List --}}
        @forelse ($kriterias as $kriteria)
            @php
                $dataPivot = $pivot_tersimpan[$kriteria->id_kriteria] ?? null;
                $isChecked = old('kriteria.'.$kriteria->id_kriteria.'.id', $dataPivot ? true : false);
                $oldBobot  = old('kriteria.'.$kriteria->id_kriteria.'.bobot', $dataPivot['bobot'] ?? '');
                $oldSyarat = old('kriteria.'.$kriteria->id_kriteria.'.syarat', $dataPivot['syarat'] ?? '');
                $skalas = $skala_tersimpan[$kriteria->id_kriteria] ?? [];
            @endphp

            <div class="border rounded p-3 mb-3 {{ $isChecked ? 'border-primary' : 'border-light' }}" id="card-{{ $kriteria->id_kriteria }}">

                {{-- Main Row --}}
                <div class="row align-items-center gy-2">

                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   id="kriteria-{{ $kriteria->id_kriteria }}"
                                   name="kriteria[{{ $kriteria->id_kriteria }}][id]"
                                   value="{{ $kriteria->id_kriteria }}"
                                   onchange="toggleActive({{ $kriteria->id_kriteria }})"
                                   {{ $isChecked ? 'checked' : '' }}>

                            <label class="form-check-label fw-semibold" for="kriteria-{{ $kriteria->id_kriteria }}">
                                {{ $kriteria->nama_kriteria }}
                            </label>

                            <span class="badge ms-2 {{ $kriteria->jenis == 'Benefit' ? 'bg-success' : 'bg-danger' }}">
                                {{ $kriteria->jenis }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3 input-area-{{ $kriteria->id_kriteria }}" style="{{ $isChecked ? '' : 'opacity:.4;pointer-events:none' }}">
                        <input type="number" step="0.01" min="0" max="1"
                               class="form-control text-center fw-semibold bobot-input"
                               name="kriteria[{{ $kriteria->id_kriteria }}][bobot]"
                               placeholder="Bobot"
                               value="{{ $oldBobot }}">
                    </div>

                    <div class="col-md-5 input-area-{{ $kriteria->id_kriteria }}" style="{{ $isChecked ? '' : 'opacity:.4;pointer-events:none' }}">
                        <input type="text" class="form-control"
                               name="kriteria[{{ $kriteria->id_kriteria }}][syarat]"
                               placeholder="Syarat / Kualifikasi"
                               value="{{ $oldSyarat }}">
                    </div>
                </div>

                {{-- Skala --}}
                <div class="mt-3 ps-4 skala-container" id="skala-box-{{ $kriteria->id_kriteria }}" style="display: {{ $isChecked ? 'block' : 'none' }}">
                    <div class="mb-2">
                        <small class="fw-semibold text-primary">Sub-Kriteria (Skala)</small>
                    </div>

                    <div class="row g-2 mb-1" style="font-size: 0.70rem;">
                        <div class="col-8 text-muted fw-bold">DESKRIPSI SUB-KRITERIA</div>
                        <div class="col-2 text-muted fw-bold">NILAI (1-5)</div>
                        <div class="col-1 text-muted fw-bold text-center">AKSI</div>
                    </div>

                    <div class="skala-wrapper" id="wrapper-{{ $kriteria->id_kriteria }}">
                        @forelse($skalas as $index => $skala)
                            @php
                                $totalData = count($skalas);
                            @endphp

                            <div class="row g-2 align-items-center mb-2 skala-row">
                                {{-- Kolom Deskripsi --}}
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm"
                                        name="skala[{{ $kriteria->id_kriteria }}][{{ $index }}][deskripsi]"
                                        value="{{ $skala->deskripsi }}" placeholder="Contoh: S1 Ilmu Komunikasi">
                                </div>
                                
                                {{-- Kolom Nilai --}}
                                <div class="col-2">
                                    <select class="form-select form-select-sm text-center fw-bold nilai-input" 
                                            onfocus="updateOptions({{ $kriteria->id_kriteria }})"
                                            onmousedown="updateOptions({{ $kriteria->id_kriteria }})"
                                            onchange="updateOptions({{ $kriteria->id_kriteria }})"
                                            name="skala[{{ $kriteria->id_kriteria }}][{{ $index }}][nilai]">
                                        {{-- Opsi Default --}}
                                        <option value="" disabled hidden>-</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $skala->nilai == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                {{-- Kolom Aksi --}}
                                <div class="col-1 text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 btn-hapus" 
                                            style="{{ $totalData <= 1 ? 'display: none;' : '' }}"
                                            onclick="removeSkala(this, {{ $kriteria->id_kriteria }})" title="Hapus">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="row g-2 align-items-center mb-2 skala-row">
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm"
                                        name="skala[{{ $kriteria->id_kriteria }}][0][deskripsi]"
                                        placeholder="Deskripsi sub-kriteria...">
                                </div>
                                <div class="col-2">
                                    <select class="form-select form-select-sm text-center fw-bold nilai-input" 
                                            onfocus="updateOptions({{ $kriteria->id_kriteria }})"
                                            onmousedown="updateOptions({{ $kriteria->id_kriteria }})"
                                            onchange="updateOptions({{ $kriteria->id_kriteria }})"
                                            name="skala[{{ $kriteria->id_kriteria }}][0][nilai]">
                                        <option value="" selected disabled hidden>-</option>
                                        <option value="1">1</option><option value="2">2</option>
                                        <option value="3">3</option><option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col-1 text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1 btn-hapus" 
                                            style="display: none;"
                                            onclick="removeSkala(this, {{ $kriteria->id_kriteria }})">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button" 
                            id="btn-add-{{ $kriteria->id_kriteria }}"
                            class="btn btn-sm btn-outline-primary mt-2"
                            style="{{ count($skalas) >= 5 ? 'display:none' : '' }}"
                            onclick="addSkalaRow({{ $kriteria->id_kriteria }})">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Sub-Kriteria
                    </button>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada kriteria.</p>
        @endforelse

        {{-- Footer --}}
        <div class="position-sticky bottom-0 bg-white border-top shadow-sm rounded-top-4 py-3 mt-4 px-4" style="z-index: 1020;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted fw-bold text-uppercase ls-1">Total Bobot</small>
                    <div id="displayTotal" class="fw-bolder fs-4 text-danger">0.00</div>
                </div>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill transition-btn">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
            </div>
        </div>
        </form>
        </div>

<style>
    .transition-btn {
        transition: all 0.3s ease;
    }
    .transition-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .ls-1 { letter-spacing: 1px; }
</style>

{{-- Scripts --}}
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
        card.classList.add('border-primary');
    } else {
        inputs.forEach(el => {
            el.style.opacity = '0.4';
            el.style.pointerEvents = 'none';
        });
        skalaBox.style.display = 'none';
        card.classList.remove('border-primary');
        document.querySelector(`input[name="kriteria[${id}][bobot]"]`).value = '';
        calculateTotal();
    }
}

// 1. Fungsi Tambah Baris
function addSkalaRow(id) {
    const wrapper = document.getElementById(`wrapper-${id}`);
    const currentRows = wrapper.querySelectorAll('.skala-row').length;

    if (currentRows >= 5) {
        alert('Maksimal 5 sub-kriteria diperbolehkan.');
        return;
    }

    const index = Date.now();
    
    const html = `
        <div class="row g-2 align-items-center mb-2 skala-row">
            <div class="col-8">
                <input type="text" class="form-control form-control-sm"
                       name="skala[${id}][${index}][deskripsi]" placeholder="Deskripsi sub-kriteria...">
            </div>
            <div class="col-2">
                <select class="form-select form-select-sm text-center fw-bold nilai-input" 
                        onchange="updateOptions(${id})"
                        onfocus="updateOptions(${id})"
                        name="skala[${id}][${index}][nilai]">
                    <option value="" selected disabled hidden>-</option>
                    <option value="1">1</option><option value="2">2</option>
                    <option value="3">3</option><option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="col-1 text-center">
                <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1" 
                        onclick="removeSkala(this, ${id})">
                    ✕
                </button>
            </div>
        </div>`;
        
    wrapper.insertAdjacentHTML('beforeend', html);
    
    checkLimit(id);
    updateOptions(id); 
}

// 2. Fungsi Hapus Baris
function removeSkala(btn, id) {
    btn.closest('.skala-row').remove();
    checkLimit(id);
    updateOptions(id);
}

// 3. Wrapper untuk menjalankan semua logika update sekaligus
function refreshAllLogic(id) {
    checkLimit(id);        
    updateOptions(id);     
    toggleDeleteButtons(id); 
}

// 4. LOGIKA BARU: Sembunyikan tombol hapus jika cuma 1 baris
function toggleDeleteButtons(id) {
    const wrapper = document.getElementById(`wrapper-${id}`);
    const rows = wrapper.querySelectorAll('.skala-row');
    const buttons = wrapper.querySelectorAll('.btn-hapus');

    if (rows.length <= 1) {
        buttons.forEach(btn => btn.style.display = 'none');
    } else {
        buttons.forEach(btn => btn.style.display = 'inline-block');
    }
}

// 5. Logic Cek Limit Tombol Tambah
function checkLimit(id) {
    const wrapper = document.getElementById(`wrapper-${id}`);
    const btnAdd = document.getElementById(`btn-add-${id}`);
    if(!wrapper || !btnAdd) return;
    
    const count = wrapper.querySelectorAll('.skala-row').length;
    btnAdd.style.display = (count >= 5) ? 'none' : 'inline-block';
}

// 6. MAIN LOGIC: Disable Opsi yang Sudah Terpakai
function updateOptions(id) {
    const wrapper = document.getElementById(`wrapper-${id}`);
    const selects = wrapper.querySelectorAll('.nilai-input');
    
    let usedValues = [];
    selects.forEach(select => {
        if (select.value) {
            usedValues.push(select.value);
        }
    });

    // Langkah 2: Loop semua dropdown untuk update status opsinya
    selects.forEach(select => {
        const options = select.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === "") return;
            const isUsedElsewhere = usedValues.includes(option.value) && option.value !== select.value;

            if (isUsedElsewhere) {
                option.disabled = true;             
                option.style.color = '#d1d5db';    
                option.style.backgroundColor = '#f8f9fa';
            } else {
                option.disabled = false;           
                option.style.color = '';           
                option.style.backgroundColor = ''; 
            }
        });
    });
}

// 7. Jalankan saat halaman pertama kali dimuat (untuk data tersimpan)
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.skala-container').forEach(container => {
        const id = container.id.replace('skala-box-', '');
        updateOptions(id);
    });
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.bobot-input').forEach(input => {
        if (!input.closest('[style*="pointer-events: none"]')) {
            total += parseFloat(input.value || 0);
        }
    });

    const display = document.getElementById('displayTotal');
    display.innerText = total.toFixed(2);
    display.classList.toggle('text-success', Math.abs(total - 1) < 0.001);
    display.classList.toggle('text-danger', Math.abs(total - 1) >= 0.001);
}

document.querySelectorAll('.bobot-input').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection