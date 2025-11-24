@extends('layouts.admin')

@section('title', 'Hasil SAW: ' . $lowongan->posisi->nama_posisi)

@section('content')
<div class="container mt-4 mb-5">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-dark mb-0 fw-bold">Hasil Perangkingan SAW</h3>
            <p class="text-muted small mb-0">Daftar pelamar diurutkan berdasarkan skor tertinggi.</p>
        </div>
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

    {{-- Info Lowongan --}}
    <div class="card mb-4 card-dark card-outline shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-briefcase mr-2"></i> {{ $lowongan->posisi->nama_posisi }} 
                <small class="text-muted ml-2">({{ $lowongan->dealer->singkatan }})</small>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Periode:</p>
                    <p class="fw-bold text-dark">
                        {{ $lowongan->tgl_buka->format('d F Y') }} — {{ $lowongan->tgl_tutup->format('d F Y') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1 text-muted">Kriteria (Bobot):</p>
                    <div>
                        @foreach($kriterias as $k) 
                            <span class="badge badge-dark mr-1 mb-1 p-2">
                                {{ $k->nama_kriteria }} 
                                <span class="badge badge-light ml-1 text-dark">{{ $k->pivot->bobot_saw }}</span>
                            </span> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success')) 
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }} 
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                <span>&times;</span>
            </button>
        </div> 
    @endif
    @if(session('error')) 
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }} 
            <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                <span>&times;</span>
            </button>
        </div> 
    @endif

    {{-- Tabel Utama --}}
    <div class="card shadow-sm border-top border-dark">
        <div class="card-header bg-white">
            <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-list-ol mr-2"></i> Tabel Peringkat</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th width="50" class="text-center">Rank</th>
                        <th>Nama Pelamar</th>
                        <th width="100" class="text-center">Nilai (V)</th>
                        <th width="120" class="text-center">Simpan</th>
                        <th width="150" class="text-center">Status</th>
                        <th width="280" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @forelse ($hasil_akhir as $h)
                        @php 
                            $lamaran = \App\Models\Lamaran::with(['jawabanAdministrasi.kriteria', 'jawabanAdministrasi.skalaNilai'])->find($h['lamaran_id']); 
                            $isSaved = isset($h['nilai_disimpan']) && (float)$h['nilai_v'] == (float)$h['nilai_disimpan'];
                            $st = $h['status_lamaran'];
                        @endphp
                        <tr>
                            <td class="text-center font-weight-bold">{{ $rank++ }}</td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">{{ $h['pelamar'] }}</span>
                                    <button type="button" class="btn btn-xs btn-info text-white ml-2 rounded-circle" 
                                            onclick="openModal('modalJwb-{{ $h['lamaran_id'] }}')" 
                                            title="Lihat Jawaban">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge badge-light border border-dark text-dark fs-6">{{ $h['nilai_v'] }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge {{ $isSaved ? 'badge-success' : 'badge-warning text-dark' }}">
                                    {{ $isSaved ? 'Tersimpan' : 'Belum' }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge {{ $st == 'Lolos Administrasi' ? 'badge-success' : ($st == 'Gagal Administrasi' ? 'badge-danger' : 'badge-warning text-dark') }} p-2">
                                    {{ $st }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                @if($lamaran) 
                                    <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" target="_blank" class="btn btn-info btn-sm me-1">Detail</a> 
                                @endif
                                @if(in_array($st, ['Proses Administrasi', 'Gagal Administrasi'])) 
                                    <form action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" method="POST" class="d-inline">
                                        @csrf 
                                        <input type="hidden" name="status" value="Lolos Administrasi">
                                        <button class="btn btn-success btn-sm me-1" onclick="return confirm('Loloskan?')">Lolos</button>
                                    </form> 
                                @endif
                                @if(in_array($st, ['Proses Administrasi', 'Lolos Administrasi'])) 
                                    <form action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" method="POST" class="d-inline">
                                        @csrf 
                                        <input type="hidden" name="status" value="Gagal Administrasi">
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Gagalkan?')">Gagal</button>
                                    </form> 
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pelamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========== MODAL DIPINDAHKAN KE LUAR LOOP ========== --}}
@foreach ($hasil_akhir as $h)
    @php 
        $lamaran = \App\Models\Lamaran::with(['jawabanAdministrasi.kriteria', 'jawabanAdministrasi.skalaNilai'])
                    ->find($h['lamaran_id']); 
    @endphp

    <div class="custom-modal" id="modalJwb-{{ $h['lamaran_id'] }}" style="display:none;">
        <div class="custom-modal-overlay" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')"></div>
        <div class="custom-modal-dialog">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h5 class="modal-title">Jawaban: <strong>{{ $h['pelamar'] }}</strong></h5>
                    <button type="button" class="close-btn" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')">&times;</button>
                </div>
                <div class="custom-modal-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kriteria</th>
                                <th>Jawaban</th>
                                <th width="10%" class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($lamaran)
                                @foreach($lamaran->jawabanAdministrasi as $jb)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jb->kriteria->nama_kriteria ?? '-' }}</td>
                                        <td>{{ $jb->skalaNilai->deskripsi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $jb->skalaNilai->nilai ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="custom-modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Script & Style Manual untuk Modal --}}
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
        document.body.style.overflow = 'hidden'; 
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
        document.body.style.overflow = 'auto'; 
    }
</script>

<style>
    /* Custom Modal CSS */
    .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: none; align-items: center; justify-content: center; }
    .custom-modal-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .custom-modal-dialog { position: relative; width: 90%; max-width: 800px; background: #fff; border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); animation: fadeIn 0.3s; z-index: 10000; }
    .custom-modal-header { padding: 15px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; }
    .custom-modal-body { max-height: 70vh; overflow-y: auto; }
    .custom-modal-footer { padding: 10px 15px; border-top: 1px solid #dee2e6; text-align: right; }
    .close-btn { background: none; border: none; font-size: 1.5rem; font-weight: 700; line-height: 1; color: #000; opacity: 0.5; cursor: pointer; }
    .close-btn:hover { opacity: 0.75; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
