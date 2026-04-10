@extends('layouts.public')
@section('title', 'Cari Lowongan Kerja - Lautan Teduh')

@section('content')

{{-- 1. HERO SECTION --}}
<div class="hero-section position-relative d-flex align-items-center text-white" 
     style="background-image: url('{{ asset('img/bg_perusahaan.jpg') }}'); 
            background-size: cover; 
            background-position: center; 
            min-height: 50vh;"> 
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    
    <div class="container position-relative z-3 text-center">
        <h1 class="display-4 fw-bold mb-3">Temukan Karir Impianmu</h1>
        <p class="lead mb-4 fs-4">
            Bergabunglah dengan tim terbaik <strong>PT. Lautan Teduh Interniaga</strong><br>
            dan wujudkan potensi terbaikmu.
        </p>
        
        <div class="bg-white p-2 rounded-pill shadow-lg d-inline-flex align-items-center mx-auto mt-3" style="max-width: 600px; width: 100%;">
            <i class="fas fa-search text-muted ms-3 me-2"></i>
            <input type="text"
            id="searchInput"
            class="form-control border-0 shadow-none text-dark"
            placeholder="Ketik posisi atau nama dealer..." autocomplete="off">
        </div>
    </div>
</div>

<div class="container-fluid py-4" style="background: #f5f7fa;">
    <div class="container">
        
        {{-- 2. DESKRIPSI PERUSAHAAN (Diletakkan di atas informasi lowongan) --}}
        <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-10">
                    <h4 class="fw-bold text-navy mb-3">Tentang PT Lautan Teduh Interniaga</h4>
                    <p class="text-secondary mb-0" style="line-height: 1.8; text-align: justify;">
                        <strong>PT Lautan Teduh Interniaga</strong> adalah Main Dealer sepeda motor Yamaha yang berlokasi di Bandar Lampung, Lampung. 
                        Perusahaan ini bergerak di bidang penjualan, servis, dan suku cadang kendaraan bermotor. Sebagai perusahaan 
                        yang berkembang, mereka berfokus pada pelayanan maksimal bagi konsumen motor Yamaha di wilayah Lampung.
                    </p>
                </div>
            </div>
        </div>

        {{-- 3. SISTEM LOWONGAN KERJA --}}
        <div class="row g-0 border rounded overflow-hidden shadow-sm bg-white" style="height: 80vh;">
            
            {{-- SIDEBAR DAFTAR LOWONGAN --}}
            <div class="col-md-4 d-flex flex-column border-end h-100 bg-white">
                <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-navy mb-0">
                        <span id="jobCount">{{ $lowongans->total() }}</span> Lowongan Tersedia
                    </h6>
                </div>
                
                <div class="flex-grow-1 overflow-auto custom-scroll p-3 position-relative">
                    <div id="jobListContainer">
                        @forelse($lowongans as $job)
                        <div class="card mb-3 job-card job-item border shadow-sm" 
                            onclick="selectJob(this, {{ $job->id_lowongan }})"
                            style="cursor: pointer; transition: 0.2s;">
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-primary mb-1">{{ $job->posisi->nama_posisi }}</h6>
                                <div class="small text-muted mb-2">
                                    <i class="fas fa-building me-1"></i> {{ $job->dealer->nama_dealer }}
                                </div>
                                <div class="d-flex justify-content-between align-items-center small">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-map-marker-alt text-secondary"></i> {{ $job->dealer->kota }}
                                    </span>
                                    <span class="text-danger" style="font-size: 11px;">
                                        Tutup: {{ $job->tgl_tutup->format('d M Y') }}
                                    </span>
                                </div>
                                {{-- Data Tersembunyi untuk Pencarian --}}
                                <span class="d-none search-data">
                                    {{ strtolower($job->posisi->nama_posisi) }} 
                                    {{ strtolower($job->dealer->nama_dealer) }} 
                                    {{ strtolower($job->dealer->kota) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2"></i>
                            <p>Belum ada lowongan saat ini.</p>
                        </div>
                        @endforelse
                    </div>

                    <div id="noResults" class="text-center py-5 d-none w-100 mt-4">
                        <div class="text-muted opacity-50 mb-2">
                            <i class="fas fa-search fa-3x"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Lowongan tidak ditemukan</h6>
                        <p class="text-muted small">Coba kata kunci lain.</p>
                    </div>

                    @if($lowongans->hasPages())
                    <div class="mt-2 pagination-container">
                        {{ $lowongans->links('pagination::simple-bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- PANEL DETAIL LOWONGAN --}}
            <div class="col-md-8 h-100 overflow-auto custom-scroll position-relative bg-white">
                <div id="emptyState" class="d-flex flex-column align-items-center justify-content-center h-100 text-center p-5">
                    <div class="bg-light rounded-circle p-4 mb-3">
                        <i class="fas fa-mouse-pointer fa-3x text-secondary"></i>
                    </div>
                    <h4 class="fw-bold text-navy">Pilih Lowongan Pekerjaan</h4>
                    <p class="text-muted">Klik salah satu lowongan di sebelah kiri untuk melihat detail lengkap, kualifikasi, dan cara melamar.</p>
                </div>

                <div id="detailLoading" class="d-none align-items-center justify-content-center h-100">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                <div id="detailContent" class="p-4 d-none">
                    {{-- Diisi via JavaScript --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --navy: #103783; }
    .text-navy { color: var(--navy) !important; }
    .job-card:hover { border-color: var(--navy) !important; background-color: #f8faff; }
    .job-card.active { border: 2px solid var(--navy) !important; background-color: #f0f4ff; }
    .custom-scroll::-webkit-scrollbar { width: 10px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 5px;
        border: 2px solid #f1f1f1;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. LOGIC PENCARIAN ---
        const searchInput = document.getElementById('searchInput');
        const jobItems = document.querySelectorAll('.job-item'); 
        const noResults = document.getElementById('noResults');
        const pagination = document.querySelector('.pagination-container');

        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                const keyword = e.target.value.toLowerCase().trim();
                let visibleCount = 0;

                jobItems.forEach(function(card) {
                    const searchData = card.querySelector('.search-data').textContent.toLowerCase();
                    if (searchData.includes(keyword)) {
                        card.classList.remove('d-none'); 
                        visibleCount++;
                    } else {
                        card.classList.add('d-none');
                    }
                });

                if (visibleCount === 0) {
                    noResults.classList.remove('d-none'); 
                    if(pagination) pagination.classList.add('d-none'); 
                } else {
                    noResults.classList.add('d-none'); 
                    if(pagination) pagination.classList.remove('d-none'); 
                }
            });
        }

        // --- 2. LOGIC PILIH LOWONGAN ---
        window.selectJob = function(element, jobId) {
            const emptyState = document.getElementById('emptyState');
            const detailLoading = document.getElementById('detailLoading');
            const detailContent = document.getElementById('detailContent');

            document.querySelectorAll('.job-card').forEach(c => c.classList.remove('active'));
            element.classList.add('active');

            if(emptyState) {
                emptyState.classList.add('d-none');
                emptyState.classList.remove('d-flex');
            }
            if(detailContent) detailContent.classList.add('d-none');
            if(detailLoading) {
                detailLoading.classList.remove('d-none');
                detailLoading.classList.add('d-flex');
            }

            fetch(`/lowongan/${jobId}/detail`)
                .then(res => res.json())
                .then(data => {
                    renderDetail(data);
                    detailLoading.classList.add('d-none');
                    detailLoading.classList.remove('d-flex');
                    detailContent.classList.remove('d-none');
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data detail lowongan.');
                    detailLoading.classList.add('d-none');
                });
        }

        // --- 3. RENDER HTML DETAIL ---
        function renderDetail(job) {
            const isLoggedIn = {{ Auth::guard('pelamar')->check() ? 'true' : 'false' }};
            const loginUrl = "{{ route('login') }}";
            const applyUrl = `/pelamar/lamar/${job.id}`;
            const detailContainer = document.getElementById('detailContent');

            detailContainer.innerHTML = `
                <h2 class="fw-bold text-navy mb-1">${job.posisi}</h2>
                <div class="text-muted mb-4">
                    <i class="fas fa-building me-1"></i> ${job.dealer} &nbsp;|&nbsp; 
                    <i class="fas fa-map-marker-alt me-1"></i> ${job.kota}
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-uppercase text-muted fw-bold" style="font-size:10px">Dibuka</small>
                            <div class="fw-bold text-dark">${job.tgl_buka}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-uppercase text-muted fw-bold" style="font-size:10px">Tutup</small>
                            <div class="fw-bold text-danger">${job.tgl_tutup}</div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold border-bottom pb-2 mb-3">Deskripsi Pekerjaan</h5>
                <div class="text-secondary mb-4" style="line-height:1.6">${job.deskripsi || '-'}</div>

                ${job.kriteria && job.kriteria.length ? `
                <h5 class="fw-bold border-bottom pb-2 mb-3">Kualifikasi</h5>
                <ul class="text-secondary mb-5">
                    ${job.kriteria.map(k => `<li class="mb-2">${k}</li>`).join('')}
                </ul>` : ''}

                <div class="d-grid gap-2 sticky-bottom bg-white pt-3 border-top">
                    <a href="${isLoggedIn ? applyUrl : loginUrl}" 
                       class="btn btn-primary btn-lg fw-bold shadow-sm" 
                       style="background: var(--navy); border:none; border-radius: 50px;">
                       ${isLoggedIn ? 'Lamar Sekarang' : 'Login untuk Melamar'}
                    </a>
                </div>
            `;
        }
    });
</script>
@endsection