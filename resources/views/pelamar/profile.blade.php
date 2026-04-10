@extends('layouts.public')

@section('title', 'Lengkapi Profil - Lautan Karir')

@section('content')
<div class="bg-navy text-white py-5 mb-n5 shadow-sm" style="background: linear-gradient(135deg, #103783 0%, #4b6cb7 100%); padding-bottom: 80px !important;">
    <div class="container">
        <h3 class="fw-bold mb-1 text-center">Lengkapi Profil Anda</h3>
        <p class="text-center opacity-75 mb-0">Data diri yang lengkap meningkatkan peluang lolos seleksi.</p>
    </div>
</div>

<div class="container" style="margin-top: -40px;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                    <ul class="mb-0 small ps-3">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                {{-- Bagian Header Tab --}}
                <div class="card-header bg-white p-0">
                    <ul class="nav nav-tabs nav-justified custom-profile-tabs" id="profileTabs" role="tablist">
                        @php
                            $tabs = [
                                'pribadi' => ['icon' => 'user', 'label' => 'Pribadi'],
                                'keluarga' => ['icon' => 'users', 'label' => 'Keluarga'],
                                'pendidikan' => ['icon' => 'graduation-cap', 'label' => 'Pendidikan'],
                                'pekerjaan' => ['icon' => 'briefcase', 'label' => 'Pekerjaan'],
                                'berkas' => ['icon' => 'file-upload', 'label' => 'Berkas']
                            ];
                        @endphp
                        @foreach($tabs as $key => $tab)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-3 fw-bold {{ $loop->first ? 'active' : '' }}" 
                                        id="{{ $key }}-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ $key }}" 
                                        type="button" 
                                        role="tab">
                                    <i class="fas fa-{{ $tab['icon'] }} me-1"></i> 
                                    <span class="d-none d-md-inline">{{ $tab['label'] }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-body p-4 p-md-5 bg-light-subtle">
                    <form id="profileForm" action="{{ route('pelamar.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content" id="profileTabsContent">
                            
                            {{-- TAB 1: DATA PRIBADI --}}
                            <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-4 border-bottom pb-2">Informasi Data Diri</h5>
                                <div class="row g-4">
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Lengkap <span class="text-danger">*</span></label><input type="text" class="form-control" name="nama" value="{{ old('nama', $pelamar->nama) }}" required></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">No. KTP (NIK) <span class="text-danger">*</span></label><input type="number" class="form-control" name="no_ktp" value="{{ old('no_ktp', $pelamar->no_ktp) }}" required></div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Kewarganegaraan <span class="text-danger">*</span></label>
                                        <select class="form-select" name="kewarganegaraan" required>
                                            <option value="WNI" {{ $pelamar->kewarganegaraan == 'WNI' ? 'selected' : '' }}>WNI</option>
                                            <option value="WNA" {{ $pelamar->kewarganegaraan == 'WNA' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Tempat Lahir <span class="text-danger">*</span></label><input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $pelamar->tempat_lahir) }}" required></div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pelamar->tanggal_lahir ? \Carbon\Carbon::parse($pelamar->tanggal_lahir)->format('Y-m-d') : '') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" name="jenis_kelamin" required>
                                            <option value="L" {{ $pelamar->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ $pelamar->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    {{-- TAMBAHAN: AGAMA --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Agama <span class="text-danger">*</span></label>
                                        <select class="form-select" name="agama" required>
                                            <option value="">- Pilih Agama -</option>
                                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                                <option value="{{ $agama }}" {{ old('agama', $pelamar->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Golongan Darah <span class="text-danger">*</span></label>
                                        <select class="form-select" name="golongan_darah" required>
                                            <option value="">- Pilih -</option>
                                            @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                                <option value="{{ $goldar }}" {{ $pelamar->golongan_darah == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3"><label class="form-label fw-bold small text-muted text-uppercase">Tinggi (cm) <span class="text-danger">*</span></label><input type="number" class="form-control" name="tinggi_badan" value="{{ old('tinggi_badan', $pelamar->tinggi_badan) }}" required></div>
                                    <div class="col-md-3"><label class="form-label fw-bold small text-muted text-uppercase">Berat (kg) <span class="text-danger">*</span></label><input type="number" class="form-control" name="berat_badan" value="{{ old('berat_badan', $pelamar->berat_badan) }}" required></div>
                                    <div class="col-12"><label class="form-label fw-bold small text-muted text-uppercase">Alamat Domisili Lengkap <span class="text-danger">*</span></label><textarea class="form-control" name="alamat_domisili" rows="3" required>{{ old('alamat_domisili', $pelamar->alamat_domisili) }}</textarea></div>
                                    
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Status Tempat Tinggal <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status_tempat_tinggal" required>
                                            @foreach(['Milik Sendiri', 'Sewa/Kos', 'Orang Tua'] as $stat)
                                                <option value="{{ $stat }}" {{ $pelamar->status_tempat_tinggal == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-5 text-end border-top pt-4"><button type="button" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" onclick="nextTab('keluarga-tab')">Lanjut<i class="fas fa-arrow-right ms-2"></i></button></div>
                            </div>

                            {{-- TAB 2: KELUARGA --}}
                            <div class="tab-pane fade" id="keluarga" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-4 border-bottom pb-2">Susunan Keluarga Inti</h5>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Status Pernikahan <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status_pernikahan" required>
                                            @foreach(['Lajang', 'Menikah', 'Janda/Duda'] as $stat)
                                                <option value="{{ $stat }}" {{ $pelamar->status_pernikahan == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Ibu Kandung <span class="text-danger">*</span></label><input type="text" class="form-control" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $pelamar->nama_ibu_kandung) }}" required></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Suami/Istri (Jika Menikah)</label><input type="text" class="form-control" name="nama_suami_istri" value="{{ old('nama_suami_istri', $pelamar->nama_suami_istri) }}"></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Tgl Lahir Pasangan</label><input type="date" class="form-control" name="tanggal_lahir_pasangan" value="{{ old('tanggal_lahir_pasangan', $pelamar->tanggal_lahir_pasangan ? \Carbon\Carbon::parse($pelamar->tanggal_lahir_pasangan)->format('Y-m-d') : '') }}"></div>
                                </div>

                                <h6 class="text-navy fw-bold mt-5 mb-3"><i class="fas fa-child me-2"></i>Data Anak (Opsional)</h6>
                                <div id="anak-wrapper">
                                    @php $anakList = $pelamar->keluarga->count() > 0 ? $pelamar->keluarga : [null]; @endphp
                                    @foreach($anakList as $index => $anak)
                                    <div class="card bg-white border shadow-sm rounded-3 mb-3 anak-row">
                                        <div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2">
                                            <span class="fw-bold small text-muted">Data Anak #{{ $loop->iteration }}</span>
                                            @if(!$loop->first) <button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button> @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-5"><label class="small text-muted mb-1">Nama Anak</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][nama]" value="{{ $anak->nama ?? '' }}"></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Tgl Lahir</label><input type="date" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][tanggal_lahir]" value="{{ optional($anak)->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : '' }}"></div>
                                                <div class="col-md-4"><label class="small text-muted mb-1">Keterangan</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][keterangan]" value="{{ $anak->keterangan ?? '' }}" placeholder="Contoh: Anak ke-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-navy btn-sm rounded-pill fw-bold mt-2" onclick="addAnakRow()"><i class="fas fa-plus me-1"></i> Tambah Data Anak</button>
                                <div class="mt-5 text-end border-top pt-4">
                                    <button type="button" class="btn btn-light text-muted fw-bold me-2" onclick="prevTab('pribadi-tab')">Kembali</button>
                                    <button type="button" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" onclick="nextTab('pendidikan-tab')">Lanjut<i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            {{-- TAB 3: PENDIDIKAN & LEGALITAS --}}
                            <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-4 border-bottom pb-2">Dokumen Legalitas</h5>
                                <div class="row g-4 mb-5">
                                    <div class="col-md-4"><label class="form-label fw-bold small text-muted text-uppercase">No. NPWP</label><input type="text" class="form-control" name="no_npwp" value="{{ old('no_npwp', $pelamar->no_npwp) }}"></div>
                                    <div class="col-md-4"><label class="form-label fw-bold small text-muted text-uppercase">No. BPJS Ketenagakerjaan</label><input type="text" class="form-control" name="no_bpjs_tk" value="{{ old('no_bpjs_tk', $pelamar->no_bpjs_tk) }}"></div>
                                    <div class="col-md-4"><label class="form-label fw-bold small text-muted text-uppercase">No. BPJS Kesehatan</label><input type="text" class="form-control" name="no_bpjs_kes" value="{{ old('no_bpjs_kes', $pelamar->no_bpjs_kes) }}"></div>
                                    
                                    <div class="col-md-6">
                                        <div class="card bg-soft-navy border-0 rounded-3 h-100">
                                            <div class="card-body">
                                                <h6 class="fw-bold text-navy mb-3"><i class="fas fa-id-card me-2"></i>SIM A (Mobil)</h6>
                                                <input type="text" class="form-control mb-2" name="no_sim_a" placeholder="Nomor SIM A" value="{{ old('no_sim_a', $pelamar->no_sim_a) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-soft-navy border-0 rounded-3 h-100">
                                            <div class="card-body">
                                                <h6 class="fw-bold text-navy mb-3"><i class="fas fa-motorcycle me-2"></i>SIM C (Motor)</h6>
                                                <input type="text" class="form-control mb-2" name="no_sim_c" placeholder="Nomor SIM C" value="{{ old('no_sim_c', $pelamar->no_sim_c) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="bg-light p-3 rounded-3 border">
                                            <label class="form-label fw-bold small text-muted text-uppercase mb-3">Informasi Kendaraan Pribadi</label>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="small mb-1">Jenis Kendaraan</label>
                                                    <select class="form-select form-select-sm" name="jenis_kendaraan">
                                                        <option value="">- Pilih -</option>
                                                        @foreach(['Motor', 'Mobil', 'Keduanya'] as $v) 
                                                            <option value="{{ $v }}" {{ $pelamar->jenis_kendaraan == $v ? 'selected' : '' }}>{{ $v }}</option> 
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small mb-1">Kepemilikan</label>
                                                    <select class="form-select form-select-sm" name="kepemilikan_kendaraan">
                                                        <option value="">- Pilih -</option>
                                                        @foreach(['Milik Sendiri', 'Orang Tua', 'Milik Kantor'] as $own) 
                                                            <option value="{{ $own }}" {{ $pelamar->kepemilikan_kendaraan == $own ? 'selected' : '' }}>{{ $own }}</option> 
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small mb-1">Merk & Tahun</label>
                                                    <input type="text" class="form-control form-control-sm" name="merk_kendaraan" placeholder="Contoh: Honda Vario 2022" value="{{ old('merk_kendaraan', $pelamar->merk_kendaraan) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-navy fw-bold mb-3 pt-4 border-top"><i class="fas fa-university me-2"></i>Riwayat Pendidikan <span class="text-danger fw-bold fs-6">(Minimal 1 Wajib)</span></h5>
                                <div id="pendidikan-wrapper">
                                    @php $pendidikanList = $pelamar->pendidikan->count() > 0 ? $pelamar->pendidikan : [null]; @endphp
                                    @foreach($pendidikanList as $index => $edu)
                                    <div class="card bg-white border shadow-sm rounded-3 mb-3 pendidikan-row">
                                        <div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2">
                                            <span class="fw-bold small text-muted">Pendidikan #{{ $loop->iteration }}</span>
                                            @if(!$loop->first) <button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this, true)"><i class="fas fa-trash-alt small"></i></button> @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-2"><label class="small text-muted mb-1">Jenjang <span class="text-danger">*</span></label><select class="form-select form-select-sm bg-light" name="pendidikan[{{ $index }}][jenjang]" required>@foreach(['SMA/SMK', 'D3', 'S1', 'S2'] as $j) <option value="{{ $j }}" {{ optional($edu)->jenjang == $j ? 'selected' : '' }}>{{ $j }}</option> @endforeach</select></div>
                                                <div class="col-md-4"><label class="small text-muted mb-1">Nama Sekolah/Univ <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ $edu->nama_sekolah ?? '' }}" required></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Jurusan <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][jurusan]" value="{{ $edu->jurusan ?? '' }}" required></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Kota <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][kota]" value="{{ $edu->kota ?? '' }}" required></div>
                                                <div class="col-md-2"><label class="small text-muted mb-1">Thn Lulus <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][tahun_lulus]" value="{{ $edu->tahun_lulus ?? '' }}" required></div>
                                                <div class="col-md-2"><label class="small text-muted mb-1">Nilai/IPK <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][nilai_akhir]" value="{{ $edu->nilai_akhir ?? '' }}" required></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-navy btn-sm rounded-pill fw-bold mt-2" onclick="addPendidikanRow()"><i class="fas fa-plus me-1"></i> Tambah Pendidikan</button>
                                <div class="mt-5 text-end border-top pt-4">
                                    <button type="button" class="btn btn-light text-muted fw-bold me-2" onclick="prevTab('keluarga-tab')">Kembali</button>
                                    <button type="button" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" onclick="nextTab('pekerjaan-tab')">Lanjut<i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            {{-- TAB 4: PEKERJAAN --}}
                            <div class="tab-pane fade" id="pekerjaan" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-4 border-bottom pb-2">Riwayat Pekerjaan</h5>
                                <div id="pekerjaan-wrapper">
                                    @php $pekerjaanList = $pelamar->pekerjaan->count() > 0 ? $pelamar->pekerjaan : [null]; @endphp
                                    @foreach($pekerjaanList as $index => $job)
                                    <div class="card bg-white border shadow-sm rounded-3 mb-3 pekerjaan-row">
                                        <div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2">
                                            <span class="fw-bold small text-muted">Pekerjaan #{{ $loop->iteration }}</span>
                                            @if(!$loop->first) <button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this, true)"><i class="fas fa-trash-alt small"></i></button> @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="small text-muted mb-1">Perusahaan</label>
                                                    <input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][nama_perusahaan]" value="{{ $job->nama_perusahaan ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small text-muted mb-1">Posisi</label>
                                                    <input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][posisi]" value="{{ $job->posisi ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="small text-muted mb-1">Thn Masuk</label>
                                                    <input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][tahun_masuk]" value="{{ $job->tahun_masuk ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="small text-muted mb-1">Thn Keluar</label>
                                                    <input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][tahun_keluar]" value="{{ $job->tahun_keluar ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small text-muted mb-1">No. HP Atasan Sebelumnya</label>
                                                    <input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][nomor_atasan]" value="{{ $job->nomor_atasan ?? '' }}" placeholder="Contoh: 0812xxxxxxxx">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-outline-navy btn-sm rounded-pill fw-bold mt-2" onclick="addPekerjaanRow()"><i class="fas fa-plus me-1"></i> Tambah Pengalaman</button>
                                <div class="mt-5 text-end border-top pt-4">
                                    <button type="button" class="btn btn-light text-muted fw-bold me-2" onclick="prevTab('pendidikan-tab')">Kembali</button>
                                    <button type="button" class="btn btn-navy rounded-pill px-4 fw-bold shadow-sm" onclick="nextTab('berkas-tab')">Lanjut<i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            {{-- TAB 5: UPLOAD BERKAS --}}
                            <div class="tab-pane fade" id="berkas" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-3 border-bottom pb-2">Upload Dokumen <span class="text-danger fw-bold">(Wajib Semua, Kecuali Transkrip)</span></h5>
                                <div class="alert alert-soft-navy border-0 small mb-4 text-navy"><i class="fas fa-info-circle me-2"></i> Pastikan dokumen berukuran maksimal <strong>2MB</strong>.</div>
                                <div class="row g-4">
                                    @php
                                        $files = [
                                            'foto'          => ['label' => 'Pas Foto',       'accept' => 'image/*', 'format' => 'Format Wajib: PNG, JPG, JPEG', 'required' => true],
                                            'path_ktp'      => ['label' => 'Scan KTP',        'accept' => '.pdf',    'format' => 'Format Wajib: PDF',            'required' => true],
                                            'path_cv'       => ['label' => 'CV',              'accept' => '.pdf',    'format' => 'Format Wajib: PDF',            'required' => true],
                                            'path_ijazah'   => ['label' => 'Ijazah',          'accept' => '.pdf',    'format' => 'Format Wajib: PDF',            'required' => true],
                                            'path_kk'       => ['label' => 'KK',              'accept' => '.pdf',    'format' => 'Format Wajib: PDF',            'required' => true],
                                            'path_lamaran'  => ['label' => 'Surat Lamaran',   'accept' => '.pdf',    'format' => 'Format Wajib: PDF',            'required' => true],
                                        ];
                                    @endphp

                                    {{-- Berkas Wajib --}}
                                    @foreach($files as $name => $data)
                                        <div class="col-md-6">
                                            <div class="card h-100 border shadow-sm rounded-3">
                                                <div class="card-body">
                                                    <label class="form-label fw-bold small text-uppercase text-muted mb-1">
                                                        {{ $data['label'] }} <span class="text-danger">*</span>
                                                    </label>
                                                    <p class="text-primary fw-bold mb-2" style="font-size: 11px;">{{ $data['format'] }}</p>
                                                    <input type="file" class="form-control form-control-sm mb-2" name="{{ $name }}" accept="{{ $data['accept'] }}" {{ !$pelamar->$name ? 'required' : '' }}>
                                                    @if($pelamar->$name)
                                                        <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mt-2">
                                                            <small class="text-success fw-bold"><i class="fas fa-check me-1"></i> Berkas Tersimpan</small>
                                                            <a href="{{ Storage::url($pelamar->$name) }}" target="_blank" class="btn btn-xs btn-outline-navy py-0 px-2" style="font-size: 10px;">Lihat File</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- TAMBAHAN: TRANSKRIP (TIDAK WAJIB) --}}
                                    <div class="col-md-6">
                                        <div class="card h-100 border border-dashed shadow-sm rounded-3" style="border-style: dashed !important;">
                                            <div class="card-body">
                                                <label class="form-label fw-bold small text-uppercase text-muted mb-1">
                                                    Transkrip Nilai
                                                    <span class="badge bg-secondary ms-1" style="font-size: 9px;">Opsional</span>
                                                </label>
                                                <p class="text-primary fw-bold mb-2" style="font-size: 11px;">Format: PDF</p>
                                                <input type="file" class="form-control form-control-sm mb-2" name="path_transkrip" accept=".pdf">
                                                @if($pelamar->path_transkrip)
                                                    <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light mt-2">
                                                        <small class="text-success fw-bold"><i class="fas fa-check me-1"></i> Berkas Tersimpan</small>
                                                        <a href="{{ Storage::url($pelamar->path_transkrip) }}" target="_blank" class="btn btn-xs btn-outline-navy py-0 px-2" style="font-size: 10px;">Lihat File</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-5 pt-4 border-top d-flex justify-content-between">
                                    <button type="button" class="btn btn-light text-muted fw-bold" onclick="prevTab('pekerjaan-tab')">Kembali</button>
                                    <button type="submit" class="btn btn-navy btn-lg rounded-pill px-5 fw-bold shadow-lg transition-btn"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
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
    // AUTO PINDAH TAB JIKA ADA VALIDASI GAGAL
    document.getElementById('profileForm').addEventListener('invalid', (function(){
        return function(e) {
            e.preventDefault();
            const tabPane = e.target.closest('.tab-pane');
            const tabId = tabPane.getAttribute('id');
            const triggerEl = document.querySelector(`button[data-bs-target="#${tabId}"]`);
            bootstrap.Tab.getOrCreateInstance(triggerEl).show();
            setTimeout(() => e.target.focus(), 250);
        };
    })(), true);

    function nextTab(id) { const t = document.getElementById(id); if(t){ new bootstrap.Tab(t).show(); window.scrollTo({top:0, behavior:'smooth'}); } }
    function prevTab(id) { nextTab(id); }
    function removeRow(btn) { if(confirm('Hapus baris ini?')) { const r = btn.closest('.card'); if(r) r.remove(); } }
    
    function addAnakRow() {
        const w = document.getElementById('anak-wrapper');
        const c = w.querySelectorAll('.anak-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 anak-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Data Anak Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-5"><label class="small text-muted mb-1">Nama Anak</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[${c}][nama]" placeholder="Nama Lengkap"></div><div class="col-md-3"><label class="small text-muted mb-1">Tgl Lahir</label><input type="date" class="form-control form-control-sm bg-light" name="keluarga[${c}][tanggal_lahir]"></div><div class="col-md-4"><label class="small text-muted mb-1">Keterangan</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[${c}][keterangan]" placeholder="Keterangan"></div></div></div>`;
        w.appendChild(d);
    }

    function addPendidikanRow() {
        const w = document.getElementById('pendidikan-wrapper');
        const c = w.querySelectorAll('.pendidikan-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 pendidikan-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Pendidikan Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-2"><label class="small text-muted mb-1">Jenjang <span class="text-danger">*</span></label><select class="form-select form-select-sm bg-light" name="pendidikan[${c}][jenjang]" required><option value="SMA/SMK">SMA/SMK</option><option value="D3">D3</option><option value="S1">S1</option><option value="S2">S2</option></select></div><div class="col-md-4"><label class="small text-muted mb-1">Nama Sekolah <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][nama_sekolah]" placeholder="Nama Sekolah" required></div><div class="col-md-3"><label class="small text-muted mb-1">Jurusan <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][jurusan]" placeholder="Jurusan" required></div><div class="col-md-3"><label class="small text-muted mb-1">Kota <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][kota]" placeholder="Kota" required></div><div class="col-md-2"><label class="small text-muted mb-1">Thn Lulus <span class="text-danger">*</span></label><input type="number" class="form-control form-control-sm bg-light" name="pendidikan[${c}][tahun_lulus]" placeholder="Tahun" required></div><div class="col-md-2"><label class="small text-muted mb-1">Nilai <span class="text-danger">*</span></label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][nilai_akhir]" placeholder="Nilai" required></div></div></div>`;
        w.appendChild(d);
    }

    function addPekerjaanRow() {
        const w = document.getElementById('pekerjaan-wrapper');
        const c = w.querySelectorAll('.pekerjaan-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 pekerjaan-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Pekerjaan Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-6"><label class="small text-muted mb-1">Perusahaan</label><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][nama_perusahaan]" placeholder="Perusahaan"></div><div class="col-md-6"><label class="small text-muted mb-1">Posisi</label><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][posisi]" placeholder="Posisi"></div><div class="col-md-3"><label class="small text-muted mb-1">Thn Masuk</label><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][tahun_masuk]" placeholder="Masuk"></div><div class="col-md-3"><label class="small text-muted mb-1">Thn Keluar</label><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][tahun_keluar]" placeholder="Keluar"></div></div></div>`;
        w.appendChild(d);
    }
</script>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }

    .custom-tabs-container {
        border-bottom: 2px solid #e9ecef !important; 
        position: relative;
    }

    .custom-tabs-container .nav-link {
        color: #6c757d;
        border: none !important; 
        background: none !important;
        padding-bottom: 15px;
        position: relative;
        transition: all 0.3s ease;
    }

    .custom-tabs-container .nav-link::after {
        content: "";
        position: absolute;
        bottom: -2px; 
        left: 0;
        width: 100%;
        height: 3px;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .custom-tabs-container .nav-link.active {
        color: #103783 !important;
    }

    .custom-tabs-container .nav-link.active::after {
        background-color: #103783; 
    }

    .custom-tabs-container .nav-link:hover {
        color: #103783;
    }

    .bg-soft-navy { background-color: #f0f4f8; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #dce1e7; }
    .form-control:focus { border-color: #103783; box-shadow: none; }
    .btn-navy { background-color: #103783; color: white; border: none; transition: 0.3s; }
    .btn-navy:hover { background-color: #0a265e; transform: translateY(-2px); }
</style>
@endsection