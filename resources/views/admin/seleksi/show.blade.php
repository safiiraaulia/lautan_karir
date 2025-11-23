@extends('layouts.admin')

@section('title', 'Hasil SAW: ' . $lowongan->posisi->nama_posisi)

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-dark mb-0 fw-bold">Hasil Perangkingan SAW</h3>
            <p class="text-muted small mb-0">Daftar pelamar yang diurutkan berdasarkan skor tertinggi.</p>
        </div>
        
        {{-- [FITUR BARU] Tombol Simpan & Kembali --}}
        <div>
            <form action="{{ route('admin.seleksi.simpanRanking', $lowongan->id_lowongan) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fas fa-save mr-1"></i> Simpan Hasil
                </button>
            </form>

            <a href="{{ route('admin.seleksi.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card mb-4 card-dark card-outline shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-briefcase mr-2"></i> 
                {{ $lowongan->posisi->nama_posisi }} 
                <small class="text-muted ml-2">({{ $lowongan->dealer->singkatan }})</small>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Periode Pendaftaran:</p>
                    <p class="fw-bold text-dark">{{ $lowongan->tgl_buka->format('d F Y') }} — {{ $lowongan->tgl_tutup->format('d F Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Kriteria Penilaian (Bobot):</p>
                    <div>
                        @foreach($kriterias as $kriteria)
                            <span class="badge badge-dark mr-1 mb-1 p-2">
                                {{ $kriteria->nama_kriteria }} 
                                <span class="badge badge-light ml-1 text-dark">{{ $kriteria->pivot->bobot_saw }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card shadow-sm border-top border-dark">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-list-ol mr-2"></i> Tabel Peringkat</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="50" class="text-center">Rank</th>
                        <th>Nama Pelamar</th>
                        <th width="150" class="text-center">Nilai Akhir (V)</th>
                        <th width="150" class="text-center">Status Simpan</th>
                        <th width="180" class="text-center">Status</th>
                        <th width="300" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $ranking = 1; @endphp
                    @forelse ($hasil_akhir as $hasil)
                    @php
                        $lamaran = \App\Models\Lamaran::find($hasil['lamaran_id']);
                    @endphp
                    <tr>
                        <td class="text-center font-weight-bold">{{ $ranking++ }}</td>
                        <td class="align-middle">
                            <span class="font-weight-bold">{{ $hasil['pelamar'] }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge badge-light border border-dark text-dark" style="font-size: 14px;">
                                {{ $hasil['nilai_v'] }}
                            </span>
                        </td>

                        <td class="text-center align-middle">
                            @if(isset($hasil['nilai_disimpan']) && (float)$hasil['nilai_v'] == (float)$hasil['nilai_disimpan'])
                                <span class="badge badge-success"><i class="fas fa-check"></i> Tersimpan</span>
                            @else
                                <span class="badge badge-warning text-dark"><i class="fas fa-exclamation-circle"></i> Belum Disimpan</span>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            @if($hasil['status_lamaran'] == 'Lolos Administrasi')
                                <span class="badge badge-success p-2">Lolos Administrasi</span>
                            @elseif($hasil['status_lamaran'] == 'Gagal Administrasi')
                                <span class="badge badge-danger p-2">Gagal Administrasi</span>
                            @else
                                <span class="badge badge-warning p-2 text-dark">Proses Seleksi</span>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            @if($lamaran)
                                <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" target="_blank" class="btn btn-info btn-sm me-1">Detail</a>
                            @endif

                            @if($hasil['status_lamaran'] == 'Proses Administrasi' || $hasil['status_lamaran'] == 'Gagal Administrasi')
                                <form action="{{ route('admin.seleksi.updateStatus', $hasil['lamaran_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Lolos Administrasi">
                                    <button type="submit" class="btn btn-success btn-sm me-1" onclick="return confirm('Loloskan pelamar ini ke tahap psikotes?')">Loloskan</button>
                                </form>
                            @endif

                            @if($hasil['status_lamaran'] == 'Proses Administrasi' || $hasil['status_lamaran'] == 'Lolos Administrasi')
                                <form action="{{ route('admin.seleksi.updateStatus', $hasil['lamaran_id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Gagal Administrasi">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Gagalkan pelamar ini?')">Gagalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            Belum ada pelamar yang mengisi form administrasi SAW.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection