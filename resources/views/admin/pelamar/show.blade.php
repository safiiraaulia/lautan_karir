@extends('layouts.admin')

@section('title', 'Detail Pelamar: ' . $pelamar->nama)

@section('content')
<style>
    @media print {
        .no-print, .main-sidebar, .main-header, .content-header, .main-footer { display: none !important; }
        .content-wrapper, .container, .card { margin: 0 !important; width: 100% !important; box-shadow: none !important; border: 1px solid #ddd !important; }
        .profile-header { display: block !important; text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .bg-light, .badge { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
    .profile-header { display: none; }
    /* Foto Profil Memanjang Sesuai Permintaan */
    .img-profile-container { width: 100%; max-width: 200px; height: auto; margin: 0 auto; }
    .img-profile { width: 100%; height: auto; object-fit: cover; border: 1px solid #ddd; padding: 4px; border-radius: 4px; }
</style>

<div class="container mt-4 mb-5">
    {{-- Header Print --}}
    <div class="profile-header"><h2>CV PELAMAR - LAUTAN KARIR</h2><p>Dicetak pada: {{ date('d F Y') }}</p></div>

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div><h3 class="text-dark fw-bold mb-0">Detail Profil Pelamar</h3><p class="text-muted small mb-0">Data lengkap dan berkas administrasi pelamar.</p></div>
        <div>
            <a href="{{ route('admin.pelamar.index') }}" class="btn btn-outline-secondary me-2"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
            <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print mr-1"></i> Cetak PDF</button>
        </div>
    </div>

    <div class="row">
        {{-- Sidebar Kiri --}}
        <div class="col-md-3">
            <div class="card card-dark card-outline shadow-sm">
                <div class="card-body box-profile text-center">
                    <div class="mb-3 img-profile-container">
                        @if($pelamar->foto)
                            <img class="img-profile" src="{{ Storage::url($pelamar->foto) }}" alt="Foto Profil">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center border rounded py-5"><i class="fas fa-user fa-4x text-secondary"></i></div>
                        @endif
                    </div>
                    <h3 class="profile-username text-center">{{ $pelamar->nama }}</h3>
                    <p class="text-muted text-center mb-1">{{ $pelamar->email }}</p>
                    <p class="text-muted text-center small mb-3">{{ $pelamar->nomor_whatsapp }}</p>

                    <div class="d-grid mb-3 no-print">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pelamar->nomor_whatsapp) }}" target="_blank" class="btn btn-success btn-sm rounded-pill">
                            <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp
                        </a>
                    </div>

                    <ul class="list-group list-group-unbordered mb-3 text-start">
                        <li class="list-group-item d-flex justify-content-between">
                            <b>Status</b> <span class="badge {{ $pelamar->is_active ? 'bg-success' : 'bg-danger' }}">{{ $pelamar->is_active ? 'Aktif' : 'Non-Aktif' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>Vaksin</b> <span class="badge bg-info text-dark">{{ $pelamar->status_vaksin ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Card Berkas --}}
            <div class="card shadow-sm mt-3 no-print">
                <div class="card-header bg-dark text-white py-2"><h6 class="card-title mb-0"><i class="fas fa-file-alt mr-1"></i> Berkas & Dokumen</h6></div>
                <ul class="list-group list-group-flush">
                    @foreach(['CV' => 'path_cv', 'KTP' => 'path_ktp', 'Ijazah' => 'path_ijazah', 'KK' => 'path_kk', 'Lamaran' => 'path_lamaran'] as $label => $field)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            {{ $label }}
                            @if($pelamar->$field) 
                                <a href="{{ Storage::url($pelamar->$field) }}" target="_blank" class="btn btn-sm btn-primary py-0 px-2" title="Lihat"><i class="fas fa-eye small"></i></a> 
                            @else 
                                <span class="text-muted small">-</span> 
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Konten Kanan --}}
        <div class="col-md-9">
            {{-- Data Pribadi --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom"><h5 class="mb-0 text-dark"><i class="fas fa-id-card mr-2"></i> Data Pribadi & Fisik</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">NIK (KTP)</dt><dd class="col-sm-8 fw-bold">{{ $pelamar->no_ktp ?? '-' }}</dd>
                                
                                {{-- REVISI: Tempat & Tanggal Lahir Dipisah --}}
                                <dt class="col-sm-4 text-muted">Tempat Lahir</dt><dd class="col-sm-8">{{ $pelamar->tempat_lahir ?? '-' }}</dd>
                                <dt class="col-sm-4 text-muted">Tanggal Lahir</dt>
                                <dd class="col-sm-8">
                                    @if($pelamar->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pelamar->tanggal_lahir)->translatedFormat('d F Y') }}
                                        <span class="text-muted ms-1">({{ \Carbon\Carbon::parse($pelamar->tanggal_lahir)->age }} Thn)</span>
                                    @else - @endif
                                </dd>

                                <dt class="col-sm-4 text-muted">Jenis Kelamin</dt><dd class="col-sm-8">{{ $pelamar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                <dt class="col-sm-4 text-muted">Status Nikah</dt><dd class="col-sm-8">{{ $pelamar->status_pernikahan }}</dd>
                                <dt class="col-sm-4 text-muted">Warga Negara</dt><dd class="col-sm-8">{{ $pelamar->kewarganegaraan ?? 'WNI' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-4 text-muted">Tinggi/Berat</dt><dd class="col-sm-8">{{ $pelamar->tinggi_badan }} cm / {{ $pelamar->berat_badan }} kg</dd>
                                <dt class="col-sm-4 text-muted">Gol. Darah</dt><dd class="col-sm-8">{{ $pelamar->golongan_darah ?? '-' }}</dd>
                                <dt class="col-sm-4 text-muted">Alamat</dt><dd class="col-sm-8">{{ $pelamar->alamat_domisili }}</dd>
                                <dt class="col-sm-4 text-muted">Tempat Tinggal</dt><dd class="col-sm-8">{{ $pelamar->status_tempat_tinggal }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keluarga --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom"><h5 class="mb-0 text-dark"><i class="fas fa-users mr-2"></i> Data Keluarga</h5></div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Ibu Kandung:</strong> {{ $pelamar->nama_ibu_kandung ?? '-' }}</div>
                        <div class="col-md-6">
                            <strong>Pasangan:</strong> {{ $pelamar->nama_suami_istri ?? '-' }} 
                            @if($pelamar->tanggal_lahir_pasangan) <small class="text-muted">({{ \Carbon\Carbon::parse($pelamar->tanggal_lahir_pasangan)->format('d-m-Y') }})</small> @endif
                        </div>
                    </div>
                    <h6>Data Anak</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="bg-light"><tr><th>Nama Anak</th><th>Tanggal Lahir</th><th>Keterangan</th></tr></thead>
                            <tbody>
                                @forelse($pelamar->keluarga as $anak)
                                    <tr>
                                        <td>{{ $anak->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') }}</td>
                                        <td>{{ $anak->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted small">Tidak ada data anak.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pendidikan --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom"><h5 class="mb-0 text-dark"><i class="fas fa-graduation-cap mr-2"></i> Riwayat Pendidikan</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead><tr><th>Jenjang</th><th>Institusi</th><th>Jurusan</th><th>Kota</th><th>Lulus</th><th>Nilai</th></tr></thead>
                            <tbody>
                                @forelse($pelamar->pendidikan as $edu)
                                    <tr>
                                        <td>{{ $edu->jenjang }}</td>
                                        <td>{{ $edu->nama_sekolah }}</td>
                                        <td>{{ $edu->jurusan }}</td>
                                        <td>{{ $edu->kota }}</td>
                                        <td>{{ $edu->tahun_lulus }}</td>
                                        <td class="fw-bold">{{ $edu->nilai_akhir }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data pendidikan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pekerjaan --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom"><h5 class="mb-0 text-dark"><i class="fas fa-briefcase mr-2"></i> Pengalaman Kerja</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead><tr><th>Perusahaan</th><th>Posisi</th><th>Tahun Masuk</th><th>Tahun Keluar</th></tr></thead>
                            <tbody>
                                @forelse($pelamar->pekerjaan as $job)
                                    <tr>
                                        <td class="fw-bold">{{ $job->nama_perusahaan }}</td>
                                        <td>{{ $job->posisi }}</td>
                                        <td>{{ $job->tahun_masuk }}</td>
                                        <td>{{ $job->tahun_keluar }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data pengalaman kerja.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Legalitas --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom"><h5 class="mb-0 text-dark"><i class="fas fa-file-contract mr-2"></i> Legalitas & Kendaraan</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['NPWP' => 'no_npwp', 'BPJS TK' => 'no_bpjs_tk', 'BPJS Kes' => 'no_bpjs_kes', 'SIM A' => 'no_sim_a', 'SIM C' => 'no_sim_c'] as $lbl => $fld)
                            <div class="col-md-4"><small class="text-muted d-block">{{ $lbl }}</small><strong>{{ $pelamar->$fld ?? '-' }}</strong></div>
                        @endforeach
                        <div class="col-md-4"><small class="text-muted d-block">Kendaraan</small><strong>{{ $pelamar->jenis_kendaraan }} ({{ $pelamar->kepemilikan_kendaraan }})</strong></div>
                        <div class="col-md-4"><small class="text-muted d-block">Merk/Tahun</small><strong>{{ $pelamar->merk_kendaraan }} / {{ $pelamar->tahun_kendaraan }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection