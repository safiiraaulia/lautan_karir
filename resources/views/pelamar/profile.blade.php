@extends('layouts.public')

@section('title', 'Lengkapi Profil - Lautan Karir')

@section('content')
{{-- Hero Header Kecil --}}
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
                <div class="card-header bg-white p-0 border-bottom">
                    <ul class="nav nav-tabs nav-justified border-0" id="profileTabs" role="tablist">
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
                                <button class="nav-link py-3 border-0 fw-bold {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab">
                                    <i class="fas fa-{{ $tab['icon'] }} me-1"></i> <span class="d-none d-md-inline">{{ $tab['label'] }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-body p-4 p-md-5 bg-light-subtle">
                    <form action="{{ route('pelamar.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content" id="profileTabsContent">
                            
                            {{-- TAB 1: DATA PRIBADI --}}
                            <div class="tab-pane fade show active" id="pribadi" role="tabpanel">
                                <h5 class="text-navy fw-bold mb-4 border-bottom pb-2">Informasi Data Diri</h5>
                                <div class="row g-4">
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Lengkap</label><input type="text" class="form-control" name="nama" value="{{ old('nama', $pelamar->nama) }}" required></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">No. KTP (NIK)</label><input type="number" class="form-control" name="no_ktp" value="{{ old('no_ktp', $pelamar->no_ktp) }}"></div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Kewarganegaraan</label>
                                        <select class="form-select" name="kewarganegaraan">
                                            <option value="WNI" {{ $pelamar->kewarganegaraan == 'WNI' ? 'selected' : '' }}>WNI</option>
                                            <option value="WNA" {{ $pelamar->kewarganegaraan == 'WNA' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $pelamar->tempat_lahir) }}"></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($pelamar->tanggal_lahir)->format('Y-m-d')) }}"></div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option value="L" {{ $pelamar->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ $pelamar->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Golongan Darah</label>
                                        <select class="form-select" name="golongan_darah">
                                            <option value="">- Pilih -</option>
                                            @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                                <option value="{{ $goldar }}" {{ $pelamar->golongan_darah == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3"><label class="form-label fw-bold small text-muted text-uppercase">Tinggi (cm)</label><input type="number" class="form-control" name="tinggi_badan" value="{{ old('tinggi_badan', $pelamar->tinggi_badan) }}"></div>
                                    <div class="col-md-3"><label class="form-label fw-bold small text-muted text-uppercase">Berat (kg)</label><input type="number" class="form-control" name="berat_badan" value="{{ old('berat_badan', $pelamar->berat_badan) }}"></div>
                                    <div class="col-12"><label class="form-label fw-bold small text-muted text-uppercase">Alamat Domisili Lengkap</label><textarea class="form-control" name="alamat_domisili" rows="3">{{ old('alamat_domisili', $pelamar->alamat_domisili) }}</textarea></div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Status Tempat Tinggal</label>
                                        <select class="form-select" name="status_tempat_tinggal">
                                            @foreach(['Milik Sendiri', 'Sewa/Kos', 'Orang Tua'] as $stat)
                                                <option value="{{ $stat }}" {{ $pelamar->status_tempat_tinggal == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Status Vaksin</label>
                                        <select class="form-select" name="status_vaksin">
                                            @foreach(['Belum', 'Vaksin 1', 'Vaksin 2', 'Booster'] as $vaks)
                                                <option value="{{ $vaks }}" {{ $pelamar->status_vaksin == $vaks ? 'selected' : '' }}>{{ $vaks }}</option>
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
                                        <label class="form-label fw-bold small text-muted text-uppercase">Status Pernikahan</label>
                                        <select class="form-select" name="status_pernikahan">
                                            @foreach(['Lajang', 'Menikah', 'Janda/Duda'] as $stat)
                                                <option value="{{ $stat }}" {{ $pelamar->status_pernikahan == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Ibu Kandung</label><input type="text" class="form-control" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $pelamar->nama_ibu_kandung) }}"></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Nama Suami/Istri (Jika Menikah)</label><input type="text" class="form-control" name="nama_suami_istri" value="{{ old('nama_suami_istri', $pelamar->nama_suami_istri) }}"></div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted text-uppercase">Tgl Lahir Pasangan</label><input type="date" class="form-control" name="tanggal_lahir_pasangan" value="{{ old('tanggal_lahir_pasangan', optional($pelamar->tanggal_lahir_pasangan)->format('Y-m-d')) }}"></div>
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
                                                <div class="col-md-5"><label class="form-label small text-muted mb-1">Nama Anak</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][nama]" value="{{ $anak->nama ?? '' }}" placeholder="Nama Lengkap"></div>
                                                <div class="col-md-3"><label class="form-label small text-muted mb-1">Tgl Lahir</label><input type="date" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][tanggal_lahir]" value="{{ optional($anak)->tanggal_lahir ? $anak->tanggal_lahir->format('Y-m-d') : '' }}"></div>
                                                <div class="col-md-4"><label class="form-label small text-muted mb-1">Keterangan</label><input type="text" class="form-control form-control-sm bg-light" name="keluarga[{{ $index }}][keterangan]" value="{{ $anak->keterangan ?? '' }}" placeholder="Contoh: Anak ke-1"></div>
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
                                    @foreach(['no_npwp' => 'No. NPWP', 'no_bpjs_tk' => 'No. BPJS Ketenagakerjaan', 'no_bpjs_kes' => 'No. BPJS Kesehatan'] as $field => $label)
                                        <div class="col-md-4"><label class="form-label fw-bold small text-muted text-uppercase">{{ $label }}</label><input type="text" class="form-control" name="{{ $field }}" value="{{ old($field, $pelamar->$field) }}"></div>
                                    @endforeach
                                    
                                    @foreach(['no_sim_a' => ['icon' => 'id-card', 'label' => 'SIM A (Mobil)'], 'no_sim_c' => ['icon' => 'motorcycle', 'label' => 'SIM C (Motor)']] as $field => $data)
                                        <div class="col-md-6">
                                            <div class="card bg-soft-navy border-0 rounded-3 h-100">
                                                <div class="card-body">
                                                    <h6 class="fw-bold text-navy mb-3"><i class="fas fa-{{ $data['icon'] }} me-2"></i>{{ $data['label'] }}</h6>
                                                    <input type="text" class="form-control mb-2" name="{{ $field }}" placeholder="Nomor {{ $data['label'] }}" value="{{ old($field, $pelamar->$field) }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-12">
                                        <div class="bg-light p-3 rounded-3 border">
                                            <label class="form-label fw-bold small text-muted text-uppercase mb-3">Informasi Kendaraan Pribadi</label>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="small mb-1">Jenis Kendaraan</label>
                                                    <select class="form-select form-select-sm" name="jenis_kendaraan">
                                                        <option value="">- Pilih -</option>
                                                        @foreach(['Motor', 'Mobil', 'Keduanya'] as $v) <option value="{{ $v }}" {{ $pelamar->jenis_kendaraan == $v ? 'selected' : '' }}>{{ $v }}</option> @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small mb-1">Kepemilikan</label>
                                                    <select class="form-select form-select-sm" name="kepemilikan_kendaraan">
                                                        <option value="">- Pilih -</option>
                                                        @foreach(['Milik Sendiri', 'Orang Tua', 'Milik Kantor'] as $own) <option value="{{ $own }}" {{ $pelamar->kepemilikan_kendaraan == $own ? 'selected' : '' }}>{{ $own }}</option> @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4"><label class="small mb-1">Merk & Tahun</label><input type="text" class="form-control form-control-sm" name="merk_kendaraan" placeholder="Contoh: Honda Vario 2022" value="{{ old('merk_kendaraan', $pelamar->merk_kendaraan . ' ' . $pelamar->tahun_kendaraan) }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-navy fw-bold mb-3 pt-4 border-top"><i class="fas fa-university me-2"></i>Riwayat Pendidikan</h5>
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
                                                <div class="col-md-2"><label class="small text-muted mb-1">Jenjang</label><select class="form-select form-select-sm bg-light" name="pendidikan[{{ $index }}][jenjang]">@foreach(['SMA/SMK', 'D3', 'S1', 'S2'] as $j) <option value="{{ $j }}" {{ optional($edu)->jenjang == $j ? 'selected' : '' }}>{{ $j }}</option> @endforeach</select></div>
                                                <div class="col-md-4"><label class="small text-muted mb-1">Nama Sekolah/Univ</label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ $edu->nama_sekolah ?? '' }}"></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Jurusan</label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][jurusan]" value="{{ $edu->jurusan ?? '' }}"></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Kota</label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][kota]" value="{{ $edu->kota ?? '' }}"></div>
                                                <div class="col-md-2"><label class="small text-muted mb-1">Thn Lulus</label><input type="number" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][tahun_lulus]" value="{{ $edu->tahun_lulus ?? '' }}"></div>
                                                <div class="col-md-2"><label class="small text-muted mb-1">Nilai/IPK</label><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[{{ $index }}][nilai_akhir]" value="{{ $edu->nilai_akhir ?? '' }}"></div>
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
                                                <div class="col-md-6"><label class="small text-muted mb-1">Perusahaan</label><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][nama_perusahaan]" value="{{ $job->nama_perusahaan ?? '' }}"></div>
                                                <div class="col-md-6"><label class="small text-muted mb-1">Posisi</label><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][posisi]" value="{{ $job->posisi ?? '' }}"></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Thn Masuk</label><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][tahun_masuk]" value="{{ $job->tahun_masuk ?? '' }}"></div>
                                                <div class="col-md-3"><label class="small text-muted mb-1">Thn Keluar</label><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[{{ $index }}][tahun_keluar]" value="{{ $job->tahun_keluar ?? '' }}"></div>
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
                                <h5 class="text-navy fw-bold mb-3 border-bottom pb-2">Upload Dokumen</h5>
                                <div class="alert alert-soft-navy border-0 small mb-4 text-navy"><i class="fas fa-info-circle me-2"></i> Format: <strong>JPG, JPEG, PNG, PDF</strong>. Max <strong>2MB</strong>.</div>
                                <div class="row g-4">
                                    @php
                                        $files = [
                                            'foto' => ['label' => 'Pas Foto', 'accept' => 'image/*', 'icon' => 'check-circle'],
                                            'path_ktp' => ['label' => 'Scan KTP', 'accept' => '.pdf,image/*', 'icon' => 'eye'],
                                            'path_cv' => ['label' => 'CV', 'accept' => '.pdf', 'icon' => 'file-pdf'],
                                            'path_ijazah' => ['label' => 'Ijazah', 'accept' => '.pdf', 'icon' => 'graduation-cap'],
                                            'path_kk' => ['label' => 'KK', 'accept' => '.pdf,image/*', 'icon' => 'users'],
                                            'path_lamaran' => ['label' => 'Surat Lamaran', 'accept' => '.pdf', 'icon' => 'envelope-open-text']
                                        ];
                                    @endphp
                                    @foreach($files as $name => $data)
                                        <div class="col-md-6">
                                            <div class="card h-100 border shadow-sm rounded-3">
                                                <div class="card-body">
                                                    <label class="form-label fw-bold small text-uppercase text-muted mb-2">{{ $data['label'] }}</label>
                                                    <input type="file" class="form-control form-control-sm mb-2" name="{{ $name }}" accept="{{ $data['accept'] }}">
                                                    @if($pelamar->$name)
                                                        @if($name == 'foto')
                                                            <div class="d-flex align-items-center p-2 border rounded bg-light-subtle">
                                                                <img src="{{ Storage::url($pelamar->foto) }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                                <small class="text-success fw-bold">Tersimpan</small>
                                                            </div>
                                                        @else
                                                            <a href="{{ Storage::url($pelamar->$name) }}" target="_blank" class="btn btn-sm btn-outline-navy w-100"><i class="fas fa-{{ $data['icon'] }} me-1"></i> Lihat File</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-5 pt-4 border-top d-flex justify-content-between">
                                    <button type="button" class="btn btn-light text-muted fw-bold" onclick="prevTab('pekerjaan-tab')">Kembali</button>
                                    <button type="submit" class="btn btn-navy btn-lg rounded-pill px-5 fw-bold shadow-lg transition-btn"><i class="fas fa-save me-2"></i> Simpan Semua Data</button>
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
    function nextTab(id) { const t = document.getElementById(id); if(t){ new bootstrap.Tab(t).show(); window.scrollTo({top:0, behavior:'smooth'}); } }
    function prevTab(id) { nextTab(id); }
    function removeRow(btn) { if(confirm('Hapus baris ini?')) { const r = btn.closest('.card'); if(r) r.remove(); } }
    
    function addAnakRow() {
        const w = document.getElementById('anak-wrapper');
        const c = w.querySelectorAll('.anak-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 anak-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Data Anak Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-5"><input type="text" class="form-control form-control-sm bg-light" name="keluarga[${c}][nama]" placeholder="Nama Lengkap"></div><div class="col-md-3"><input type="date" class="form-control form-control-sm bg-light" name="keluarga[${c}][tanggal_lahir]"></div><div class="col-md-4"><input type="text" class="form-control form-control-sm bg-light" name="keluarga[${c}][keterangan]" placeholder="Keterangan"></div></div></div>`;
        w.appendChild(d);
    }

    function addPendidikanRow() {
        const w = document.getElementById('pendidikan-wrapper');
        const c = w.querySelectorAll('.pendidikan-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 pendidikan-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Pendidikan Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-2"><select class="form-select form-select-sm bg-light" name="pendidikan[${c}][jenjang]"><option value="SMA/SMK">SMA/SMK</option><option value="D3">D3</option><option value="S1">S1</option><option value="S2">S2</option></select></div><div class="col-md-4"><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][nama_sekolah]" placeholder="Nama Sekolah"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][jurusan]" placeholder="Jurusan"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][kota]" placeholder="Kota"></div><div class="col-md-2"><input type="number" class="form-control form-control-sm bg-light" name="pendidikan[${c}][tahun_lulus]" placeholder="Thn Lulus"></div><div class="col-md-2"><input type="text" class="form-control form-control-sm bg-light" name="pendidikan[${c}][nilai_akhir]" placeholder="Nilai"></div></div></div>`;
        w.appendChild(d);
    }

    function addPekerjaanRow() {
        const w = document.getElementById('pekerjaan-wrapper');
        const c = w.querySelectorAll('.pekerjaan-row').length + 1;
        const d = document.createElement('div');
        d.className = 'card bg-white border shadow-sm rounded-3 mb-3 pekerjaan-row';
        d.innerHTML = `<div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center py-2"><span class="fw-bold small text-muted">Pekerjaan Baru</span><button type="button" class="btn btn-danger btn-sm py-0 px-2" onclick="removeRow(this)"><i class="fas fa-trash-alt small"></i></button></div><div class="card-body"><div class="row g-3"><div class="col-md-6"><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][nama_perusahaan]" placeholder="Perusahaan"></div><div class="col-md-6"><input type="text" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][posisi]" placeholder="Posisi"></div><div class="col-md-3"><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][tahun_masuk]" placeholder="Masuk"></div><div class="col-md-3"><input type="number" class="form-control form-control-sm bg-light" name="pekerjaan[${c}][tahun_keluar]" placeholder="Keluar"></div></div></div>`;
        w.appendChild(d);
    }
</script>

<style>
    .text-navy { color: #103783 !important; }
    .bg-navy { background-color: #103783 !important; }
    .nav-tabs .nav-link { color: #6c757d; border-bottom: 3px solid transparent; transition: all 0.3s; }
    .nav-tabs .nav-link.active { color: #103783 !important; border-bottom: 3px solid #103783 !important; background-color: #f8f9fa; }
    .nav-tabs .nav-link:hover { color: #103783; }
    .bg-soft-navy { background-color: #eef2f6; }
    .bg-light-subtle { background-color: #f8fafd !important; }
    .form-control:focus, .form-select:focus { border-color: #4b6cb7; box-shadow: 0 0 0 0.25rem rgba(75, 108, 183, 0.1); }
    .btn-navy { background-color: #103783; color: white; border: none; }
    .btn-navy:hover { background-color: #0a265e; color: white; transform: translateY(-2px); }
    .btn-outline-navy { color: #103783; border-color: #103783; }
    .btn-outline-navy:hover { background-color: #103783; color: white; }
    .transition-btn { transition: all 0.3s ease; }
</style>
@endsection