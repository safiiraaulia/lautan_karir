@extends('layouts.public')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Lengkapi Profil Pelamar</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelamar.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold" id="pribadi-tab" data-bs-toggle="tab" data-bs-target="#pribadi" type="button" role="tab">1. Data Pribadi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="keluarga-tab" data-bs-toggle="tab" data-bs-target="#keluarga" type="button" role="tab">2. Keluarga</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="pendidikan-tab" data-bs-toggle="tab" data-bs-target="#pendidikan" type="button" role="tab">3. Pendidikan & Legalitas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="pekerjaan-tab" data-bs-toggle="tab" data-bs-target="#pekerjaan" type="button" role="tab">4. Pekerjaan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold" id="berkas-tab" data-bs-toggle="tab" data-bs-target="#berkas" type="button" role="tab">5. Upload Berkas</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="profileTabsContent">
                            
                            <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                                <h5 class="text-primary mb-3">Data Diri Utama</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" value="{{ old('nama', $pelamar->nama) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. KTP (NIK)</label>
                                        <input type="number" class="form-control" name="no_ktp" value="{{ old('no_ktp', $pelamar->no_ktp) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kewarganegaraan</label>
                                        <select class="form-select" name="kewarganegaraan">
                                            <option value="WNI" {{ $pelamar->kewarganegaraan == 'WNI' ? 'selected' : '' }}>WNI</option>
                                            <option value="WNA" {{ $pelamar->kewarganegaraan == 'WNA' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $pelamar->tempat_lahir) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($pelamar->tanggal_lahir)->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="L" {{ $pelamar->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ $pelamar->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Golongan Darah</label>
                                        <select class="form-select" name="golongan_darah">
                                            <option value="">- Pilih -</option>
                                            @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                                <option value="{{ $goldar }}" {{ $pelamar->golongan_darah == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" class="form-control" name="tinggi_badan" value="{{ old('tinggi_badan', $pelamar->tinggi_badan) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="number" class="form-control" name="berat_badan" value="{{ old('berat_badan', $pelamar->berat_badan) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Domisili Lengkap</label>
                                        <textarea class="form-control" name="alamat_domisili" rows="2">{{ old('alamat_domisili', $pelamar->alamat_domisili) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Tempat Tinggal</label>
                                        <select class="form-select" name="status_tempat_tinggal">
                                            <option value="Milik Sendiri" {{ $pelamar->status_tempat_tinggal == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                            <option value="Sewa/Kos" {{ $pelamar->status_tempat_tinggal == 'Sewa/Kos' ? 'selected' : '' }}>Sewa/Kos</option>
                                            <option value="Orang Tua" {{ $pelamar->status_tempat_tinggal == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Vaksin</label>
                                        <select class="form-select" name="status_vaksin">
                                            <option value="Belum" {{ $pelamar->status_vaksin == 'Belum' ? 'selected' : '' }}>Belum</option>
                                            <option value="Vaksin 1" {{ $pelamar->status_vaksin == 'Vaksin 1' ? 'selected' : '' }}>Vaksin 1</option>
                                            <option value="Vaksin 2" {{ $pelamar->status_vaksin == 'Vaksin 2' ? 'selected' : '' }}>Vaksin 2</option>
                                            <option value="Booster" {{ $pelamar->status_vaksin == 'Booster' ? 'selected' : '' }}>Booster</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-warning fw-bold" onclick="nextTab('keluarga-tab')">Lanjut &raquo;</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="keluarga" role="tabpanel">
                                <h5 class="text-primary mb-3">Susunan Keluarga Inti</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Status Pernikahan</label>
                                        <select class="form-select" name="status_pernikahan">
                                            <option value="Lajang" {{ $pelamar->status_pernikahan == 'Lajang' ? 'selected' : '' }}>Lajang</option>
                                            <option value="Menikah" {{ $pelamar->status_pernikahan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                            <option value="Janda/Duda" {{ $pelamar->status_pernikahan == 'Janda/Duda' ? 'selected' : '' }}>Janda/Duda</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Ibu Kandung</label>
                                        <input type="text" class="form-control" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $pelamar->nama_ibu_kandung) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Suami/Istri (Jika Menikah)</label>
                                        <input type="text" class="form-control" name="nama_suami_istri" value="{{ old('nama_suami_istri', $pelamar->nama_suami_istri) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tgl Lahir Pasangan</label>
                                        <input type="date" class="form-control" name="tanggal_lahir_pasangan" value="{{ old('tanggal_lahir_pasangan', optional($pelamar->tanggal_lahir_pasangan)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <h6 class="text-primary mt-4 mb-2">Data Anak (Isi jika ada)</h6>
                                <div id="anak-wrapper">
                                    @php
                                        $anakList = $pelamar->keluarga->count() > 0 ? $pelamar->keluarga : [null]; 
                                    @endphp
                                    
                                    @foreach($anakList as $index => $anak)
                                    <div class="row g-2 mb-2 align-items-end anak-row">
                                        <div class="col-md-5">
                                            <label class="small">Nama Anak</label>
                                            <input type="text" class="form-control" name="keluarga[{{ $index }}][nama]" value="{{ $anak->nama ?? '' }}" placeholder="Nama Anak">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small">Tgl Lahir</label>
                                            <input type="date" class="form-control" name="keluarga[{{ $index }}][tanggal_lahir]" value="{{ optional($anak)->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : '' }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small">Keterangan</label>
                                            <input type="text" class="form-control" name="keluarga[{{ $index }}][keterangan]" value="{{ $anak->keterangan ?? '' }}" placeholder="Anak ke-1">
                                        </div>
                                        <div class="col-md-1">
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-warning btn-sm fw-bold mt-2" onclick="addAnakRow()">+ Tambah Anak</button>

                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-warning fw-bold me-2" onclick="prevTab('pribadi-tab')">&laquo; Kembali</button>
                                    <button type="button" class="btn btn-warning fw-bold" onclick="nextTab('pendidikan-tab')">Lanjut &raquo;</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                                <h5 class="text-primary mb-3">Legalitas & Dokumen</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">No. NPWP</label>
                                        <input type="text" class="form-control" name="no_npwp" value="{{ old('no_npwp', $pelamar->no_npwp) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">No. BPJS Ketenagakerjaan</label>
                                        <input type="text" class="form-control" name="no_bpjs_tk" value="{{ old('no_bpjs_tk', $pelamar->no_bpjs_tk) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">No. BPJS Kesehatan</label>
                                        <input type="text" class="form-control" name="no_bpjs_kes" value="{{ old('no_bpjs_kes', $pelamar->no_bpjs_kes) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. SIM A</label>
                                        <input type="text" class="form-control" name="no_sim_a" value="{{ old('no_sim_a', $pelamar->no_sim_a) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. SIM C</label>
                                        <input type="text" class="form-control" name="no_sim_c" value="{{ old('no_sim_c', $pelamar->no_sim_c) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kendaraan</label>
                                        <select class="form-select" name="jenis_kendaraan">
                                            <option value="">- Pilih -</option>
                                            <option value="Motor" {{ $pelamar->jenis_kendaraan == 'Motor' ? 'selected' : '' }}>Motor</option>
                                            <option value="Mobil" {{ $pelamar->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                            <option value="Keduanya" {{ $pelamar->jenis_kendaraan == 'Keduanya' ? 'selected' : '' }}>Keduanya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kepemilikan</label>
                                        <select class="form-select" name="kepemilikan_kendaraan">
                                            <option value="">- Pilih -</option>
                                            <option value="Milik Sendiri" {{ $pelamar->kepemilikan_kendaraan == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                            <option value="Orang Tua" {{ $pelamar->kepemilikan_kendaraan == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="Milik Kantor" {{ $pelamar->kepemilikan_kendaraan == 'Milik Kantor' ? 'selected' : '' }}>Milik Kantor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Merk & Tahun</label>
                                        <input type="text" class="form-control" name="merk_kendaraan" placeholder="Contoh: Honda Beat 2020" value="{{ old('merk_kendaraan', $pelamar->merk_kendaraan . ' ' . $pelamar->tahun_kendaraan) }}">
                                    </div>
                                </div>

                                <h5 class="text-primary mt-4 mb-3">Riwayat Pendidikan</h5>
                                <div id="pendidikan-wrapper">
                                    @php
                                        $pendidikanList = $pelamar->pendidikan->count() > 0 ? $pelamar->pendidikan : [null]; 
                                    @endphp

                                    @foreach($pendidikanList as $index => $edu)
                                    <div class="card mb-3 bg-light border pendidikan-row">
                                        <div class="card-body position-relative">
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="removeRow(this, true)"><i class="fas fa-trash"></i></button>
                                            @endif
                                            
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="small">Jenjang</label>
                                                    <select class="form-select form-select-sm" name="pendidikan[{{ $index }}][jenjang]">
                                                        @foreach(['SMA/SMK', 'D3', 'S1', 'S2'] as $j)
                                                            <option value="{{ $j }}" {{ optional($edu)->jenjang == $j ? 'selected' : '' }}>{{ $j }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="small">Nama Sekolah/Univ</label>
                                                    <input type="text" class="form-control form-control-sm" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ $edu->nama_sekolah ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small">Jurusan</label>
                                                    <input type="text" class="form-control form-control-sm" name="pendidikan[{{ $index }}][jurusan]" value="{{ $edu->jurusan ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small">Kota</label>
                                                    <input type="text" class="form-control form-control-sm" name="pendidikan[{{ $index }}][kota]" value="{{ $edu->kota ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small">Thn Lulus</label>
                                                    <input type="number" class="form-control form-control-sm" name="pendidikan[{{ $index }}][tahun_lulus]" value="{{ $edu->tahun_lulus ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small">Nilai Rata2/IPK</label>
                                                    <input type="text" class="form-control form-control-sm" name="pendidikan[{{ $index }}][nilai_akhir]" value="{{ $edu->nilai_akhir ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-warning btn-sm fw-bold" onclick="addPendidikanRow()">+ Tambah Pendidikan</button>

                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-warning fw-bold me-2" onclick="prevTab('keluarga-tab')">&laquo; Kembali</button>
                                    <button type="button" class="btn btn-warning fw-bold" onclick="nextTab('pekerjaan-tab')">Lanjut &raquo;</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pekerjaan" role="tabpanel">
                                <h5 class="text-primary mb-3">Pengalaman Kerja</h5>
                                <div id="pekerjaan-wrapper">
                                    @php
                                        $pekerjaanList = $pelamar->pekerjaan->count() > 0 ? $pelamar->pekerjaan : [null]; 
                                    @endphp

                                    @foreach($pekerjaanList as $index => $job)
                                    <div class="card mb-3 bg-light border pekerjaan-row">
                                        <div class="card-body position-relative">
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="removeRow(this, true)"><i class="fas fa-trash"></i></button>
                                            @endif
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="small">Nama Perusahaan</label>
                                                    <input type="text" class="form-control form-control-sm" name="pekerjaan[{{ $index }}][nama_perusahaan]" value="{{ $job->nama_perusahaan ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small">Posisi Terakhir</label>
                                                    <input type="text" class="form-control form-control-sm" name="pekerjaan[{{ $index }}][posisi]" value="{{ $job->posisi ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small">Tahun Masuk</label>
                                                    <input type="number" class="form-control form-control-sm" name="pekerjaan[{{ $index }}][tahun_masuk]" value="{{ $job->tahun_masuk ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small">Tahun Keluar</label>
                                                    <input type="number" class="form-control form-control-sm" name="pekerjaan[{{ $index }}][tahun_keluar]" value="{{ $job->tahun_keluar ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-warning btn-sm fw-bold" onclick="addPekerjaanRow()">+ Tambah Pengalaman</button>

                                <div class="mt-4 text-end">
                                    <button type="button" class="btn btn-warning fw-bold me-2" onclick="prevTab('pendidikan-tab')">&laquo; Kembali</button>
                                    <button type="button" class="btn btn-warning fw-bold" onclick="nextTab('berkas-tab')">Lanjut &raquo;</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="berkas" role="tabpanel">
                                <h5 class="text-primary mb-3">Upload Dokumen Administrasi</h5>
                                <div class="alert alert-info small">
                                    <i class="fas fa-info-circle"></i> Format file yang diizinkan: JPG, JPEG, PNG, PDF. Maksimal ukuran 2MB per file.
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Pas Foto Terbaru</label>
                                        <input type="file" class="form-control mb-2" name="foto" accept="image/*">
                                        @if($pelamar->foto) 
                                            <div class="d-flex align-items-center mt-2 p-2 border rounded bg-light">
                                                <img src="{{ Storage::url($pelamar->foto) }}" alt="Foto Profil" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <small class="text-success d-block fw-bold"><i class="fas fa-check-circle"></i> Foto Tersimpan</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Scan KTP</label>
                                        <input type="file" class="form-control mb-2" name="path_ktp" accept=".pdf,image/*">
                                        @if($pelamar->path_ktp) 
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($pelamar->path_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Lihat KTP Tersimpan
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">CV (Curriculum Vitae)</label>
                                        <input type="file" class="form-control mb-2" name="path_cv" accept=".pdf">
                                        @if($pelamar->path_cv) 
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($pelamar->path_cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-pdf"></i> Lihat CV Tersimpan
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Ijazah Terakhir</label>
                                        <input type="file" class="form-control mb-2" name="path_ijazah" accept=".pdf">
                                        @if($pelamar->path_ijazah) 
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($pelamar->path_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-alt"></i> Lihat Ijazah Tersimpan
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Kartu Keluarga (KK)</label>
                                        <input type="file" class="form-control mb-2" name="path_kk" accept=".pdf,image/*">
                                        @if($pelamar->path_kk) 
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($pelamar->path_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-users"></i> Lihat KK Tersimpan
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Surat Lamaran</label>
                                        <input type="file" class="form-control mb-2" name="path_lamaran" accept=".pdf">
                                        @if($pelamar->path_lamaran) 
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($pelamar->path_lamaran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-envelope-open-text"></i> Lihat Surat Lamaran
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 text-start">
                                    <button type="button" class="btn btn-warning fw-bold" onclick="prevTab('pekerjaan-tab')">&laquo; Kembali</button>
                                </div>

                                <div class="mt-5 d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                        <i class="fas fa-save me-2"></i> Simpan Profil Saya
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // --- FUNGSI NAVIGASI TAB ---
    function nextTab(tabId) {
        const tabElement = document.getElementById(tabId);
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
            window.scrollTo(0, 0);
        }
    }

    function prevTab(tabId) {
        const tabElement = document.getElementById(tabId);
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
            window.scrollTo(0, 0);
        }
    }

    // --- FUNGSI HAPUS BARIS ---
    function removeRow(button) {
        if (confirm('Hapus baris ini?')) {
            const row = button.closest('.row') || button.closest('.card');
            if (row) row.remove();
        }
    }

    // --- FUNGSI TAMBAH ANAK ---
    function addAnakRow() {
        const wrapper = document.getElementById('anak-wrapper');
        const count = wrapper.querySelectorAll('.anak-row').length;
        
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 align-items-end anak-row';
        div.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="keluarga[${count}][nama]" placeholder="Nama Anak">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="keluarga[${count}][tanggal_lahir]">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="keluarga[${count}][keterangan]" placeholder="Anak ke-${count+1}">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
            </div>
        `;
        wrapper.appendChild(div);
    }

    // --- FUNGSI TAMBAH PENDIDIKAN ---
    function addPendidikanRow() {
        const wrapper = document.getElementById('pendidikan-wrapper');
        const count = wrapper.querySelectorAll('.pendidikan-row').length;

        const div = document.createElement('div');
        div.className = 'card mb-3 bg-light border pendidikan-row';
        div.innerHTML = `
            <div class="card-body position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="small">Jenjang</label>
                        <select class="form-select form-select-sm" name="pendidikan[${count}][jenjang]">
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="small">Nama Sekolah/Univ</label>
                        <input type="text" class="form-control form-control-sm" name="pendidikan[${count}][nama_sekolah]" placeholder="Nama Institusi">
                    </div>
                    <div class="col-md-4">
                        <label class="small">Jurusan</label>
                        <input type="text" class="form-control form-control-sm" name="pendidikan[${count}][jurusan]" placeholder="Jurusan">
                    </div>
                    <div class="col-md-4">
                        <label class="small">Kota</label>
                        <input type="text" class="form-control form-control-sm" name="pendidikan[${count}][kota]" placeholder="Kota">
                    </div>
                    <div class="col-md-4">
                        <label class="small">Thn Lulus</label>
                        <input type="number" class="form-control form-control-sm" name="pendidikan[${count}][tahun_lulus]" placeholder="Tahun">
                    </div>
                    <div class="col-md-4">
                        <label class="small">Nilai Rata2/IPK</label>
                        <input type="text" class="form-control form-control-sm" name="pendidikan[${count}][nilai_akhir]" placeholder="Contoh: 3.50">
                    </div>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
    }

    // --- FUNGSI TAMBAH PEKERJAAN ---
    function addPekerjaanRow() {
        const wrapper = document.getElementById('pekerjaan-wrapper');
        const count = wrapper.querySelectorAll('.pekerjaan-row').length;

        const div = document.createElement('div');
        div.className = 'card mb-3 bg-light border pekerjaan-row';
        div.innerHTML = `
            <div class="card-body position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="small">Nama Perusahaan</label>
                        <input type="text" class="form-control form-control-sm" name="pekerjaan[${count}][nama_perusahaan]" placeholder="Nama Perusahaan">
                    </div>
                    <div class="col-md-6">
                        <label class="small">Posisi Terakhir</label>
                        <input type="text" class="form-control form-control-sm" name="pekerjaan[${count}][posisi]" placeholder="Jabatan">
                    </div>
                    <div class="col-md-6">
                        <label class="small">Tahun Masuk</label>
                        <input type="number" class="form-control form-control-sm" name="pekerjaan[${count}][tahun_masuk]" placeholder="Tahun">
                    </div>
                    <div class="col-md-6">
                        <label class="small">Tahun Keluar</label>
                        <input type="number" class="form-control form-control-sm" name="pekerjaan[${count}][tahun_keluar]" placeholder="Tahun">
                    </div>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
    }
</script>
@endsection