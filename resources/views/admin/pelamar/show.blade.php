@extends('layouts.admin')

@section('title', 'Detail Pelamar: ' . $pelamar->nama)

@section('content')
<style>
    @media print {
        /* Sembunyikan elemen AdminLTE yang tidak perlu */
        .main-sidebar, .main-header, .content-header, .main-footer, .btn, .no-print {
            display: none !important;
        }
        /* Reset margin konten agar full page */
        .content-wrapper, .main-footer {
            margin-left: 0 !important;
            min-height: 0 !important;
            background-color: white !important;
        }
        /* Pastikan container full width */
        .container, .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }
        /* Rapikan Card */
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            margin-bottom: 20px !important;
            break-inside: avoid; /* Mencegah card terpotong di tengah halaman */
        }
        /* Header Profil */
        .profile-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        /* Paksa warna background tercetak */
        .bg-light, .table-dark, .bg-primary, .bg-success, .bg-danger, .badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
    
    /* Sembunyikan header print di tampilan layar biasa */
    .profile-header {
        display: none;
    }
</style>

<div class="container mt-4 mb-5">
    
    <div class="profile-header">
        <h2>CV PELAMAR - LAUTAN KARIR</h2>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h3 class="text-dark mb-0 fw-bold">Detail Profil Pelamar</h3>
            <p class="text-muted small mb-0">Data lengkap dan berkas administrasi pelamar.</p>
        </div>
        <div>
            <a href="{{ route('admin.pelamar.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-secondary me-2">
                <i class="fas fa-print mr-1"></i> Cetak PDF
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card card-dark card-outline shadow-sm">
                <div class="card-body box-profile text-center">
                    <div class="text-center mb-3">
                        @if($pelamar->foto)
                            <img class="img-fluid border p-1 rounded"
                                 src="{{ Storage::url($pelamar->foto) }}"
                                 alt="User profile picture"
                                 style="width: 100%; max-width: 200px; height: auto; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center border rounded" style="width: 100%; max-width: 200px; height: 250px; margin: 0 auto;">
                                <i class="fas fa-user fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{ $pelamar->nama }}</h3>
                    <p class="text-muted text-center mb-1">{{ $pelamar->email }}</p>
                    <p class="text-muted text-center small">{{ $pelamar->nomor_whatsapp }}</p>

                    <ul class="list-group list-group-unbordered mb-3 text-left">
                        <li class="list-group-item">
                            <b>Status Akun</b> 
                            <span class="float-right">
                                @if($pelamar->is_active) 
                                    <span class="badge badge-success">Aktif</span> 
                                @else 
                                    <span class="badge badge-danger">Non-Aktif</span> 
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Vaksinasi</b> 
                            <span class="float-right badge badge-info">{{ $pelamar->status_vaksin ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mt-3 no-print">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title mb-0" style="font-size: 1rem;"><i class="fas fa-file-alt mr-1"></i> Berkas & Dokumen</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            CV
                            @if($pelamar->path_cv) <a href="{{ Storage::url($pelamar->path_cv) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-download"></i></a> @else <span class="text-muted small">-</span> @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            KTP
                            @if($pelamar->path_ktp) <a href="{{ Storage::url($pelamar->path_ktp) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-download"></i></a> @else <span class="text-muted small">-</span> @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ijazah
                            @if($pelamar->path_ijazah) <a href="{{ Storage::url($pelamar->path_ijazah) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-download"></i></a> @else <span class="text-muted small">-</span> @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            KK
                            @if($pelamar->path_kk) <a href="{{ Storage::url($pelamar->path_kk) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-download"></i></a> @else <span class="text-muted small">-</span> @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Lamaran
                            @if($pelamar->path_lamaran) <a href="{{ Storage::url($pelamar->path_lamaran) }}" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-download"></i></a> @else <span class="text-muted small">-</span> @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-dark"><i class="fas fa-id-card mr-2"></i> Data Pribadi & Fisik</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted">NIK (KTP)</dt>
                                <dd class="col-sm-7 fw-bold">{{ $pelamar->no_ktp ?? '-' }}</dd>

                                <dt class="col-sm-5 text-muted">Tempat Lahir</dt>
                                <dd class="col-sm-7">{{ $pelamar->tempat_lahir ?? '-' }}</dd>

                                <dt class="col-sm-5 text-muted">Tanggal Lahir</dt>
                                <dd class="col-sm-7">
                                    @if($pelamar->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pelamar->tanggal_lahir)->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </dd>

                                <dt class="col-sm-5 text-muted">Jenis Kelamin</dt>
                                <dd class="col-sm-7">{{ $pelamar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>

                                <dt class="col-sm-5 text-muted">Kewarganegaraan</dt>
                                <dd class="col-sm-7">{{ $pelamar->kewarganegaraan ?? '-' }}</dd>
                                
                                <dt class="col-sm-5 text-muted">Status Pernikahan</dt>
                                <dd class="col-sm-7">{{ $pelamar->status_pernikahan ?? '-' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted">Tinggi / Berat</dt>
                                <dd class="col-sm-7">{{ $pelamar->tinggi_badan ?? '-' }} cm / {{ $pelamar->berat_badan ?? '-' }} kg</dd>

                                <dt class="col-sm-5 text-muted">Golongan Darah</dt>
                                <dd class="col-sm-7">{{ $pelamar->golongan_darah ?? '-' }}</dd>

                                <dt class="col-sm-5 text-muted">Alamat Domisili</dt>
                                <dd class="col-sm-7">{{ $pelamar->alamat_domisili ?? '-' }}</dd>

                                <dt class="col-sm-5 text-muted">Status Tempat Tinggal</dt>
                                <dd class="col-sm-7">{{ $pelamar->status_tempat_tinggal ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-dark"><i class="fas fa-users mr-2"></i> Data Keluarga</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Ibu Kandung:</strong> {{ $pelamar->nama_ibu_kandung ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Pasangan:</strong> {{ $pelamar->nama_suami_istri ?? '-' }} 
                            @if($pelamar->tanggal_lahir_pasangan)
                                <small class="text-muted">({{ \Carbon\Carbon::parse($pelamar->tanggal_lahir_pasangan)->format('d-m-Y') }})</small>
                            @endif
                        </div>
                    </div>

                    <h6>Data Anak</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama Anak</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelamar->keluarga as $anak)
                                    <tr>
                                        <td>{{ $anak->nama }}</td>
                                        <td>{{ optional($anak->tanggal_lahir)->format('d F Y') }}</td>
                                        <td>{{ $anak->keterangan }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Tidak ada data anak.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-dark"><i class="fas fa-graduation-cap mr-2"></i> Riwayat Pendidikan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                            <tr>
                                <th>Jenjang</th>
                                <th>Institusi</th>
                                <th>Jurusan</th>
                                <th>Kota</th>
                                <th>Lulus</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelamar->pendidikan as $edu)
                                <tr>
                                    <td><span class="badge badge-info">{{ $edu->jenjang }}</span></td>
                                    <td>{{ $edu->nama_sekolah }}</td>
                                    <td>{{ $edu->jurusan }}</td>
                                    <td>{{ $edu->kota }}</td>
                                    <td>{{ $edu->tahun_lulus }}</td>
                                    <td>{{ $edu->nilai_akhir }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada data pendidikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-dark"><i class="fas fa-briefcase mr-2"></i> Pengalaman Kerja</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                            <tr>
                                <th>Perusahaan</th>
                                <th>Posisi</th>
                                <th>Tahun Masuk</th>
                                <th>Tahun Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelamar->pekerjaan as $job)
                                <tr>
                                    <td><strong>{{ $job->nama_perusahaan }}</strong></td>
                                    <td>{{ $job->posisi }}</td>
                                    <td>{{ $job->tahun_masuk }}</td>
                                    <td>{{ $job->tahun_keluar }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada data pengalaman kerja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 text-dark"><i class="fas fa-file-contract mr-2"></i> Legalitas & Kendaraan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>NPWP:</strong> {{ $pelamar->no_npwp ?? '-' }}</li>
                                <li class="mb-2"><strong>BPJS TK:</strong> {{ $pelamar->no_bpjs_tk ?? '-' }}</li>
                                <li class="mb-2"><strong>BPJS Kes:</strong> {{ $pelamar->no_bpjs_kes ?? '-' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>SIM A:</strong> {{ $pelamar->no_sim_a ?? '-' }}</li>
                                <li class="mb-2"><strong>SIM C:</strong> {{ $pelamar->no_sim_c ?? '-' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Kendaraan:</strong> {{ $pelamar->jenis_kendaraan ?? '-' }}</li>
                                <li class="mb-2"><strong>Kepemilikan:</strong> {{ $pelamar->kepemilikan_kendaraan ?? '-' }}</li>
                                <li class="mb-2"><strong>Merk/Thn:</strong> {{ $pelamar->merk_kendaraan ?? '-' }} / {{ $pelamar->tahun_kendaraan ?? '-' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection