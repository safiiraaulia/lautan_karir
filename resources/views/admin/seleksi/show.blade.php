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
            <div class="table-responsive">
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
                                $lamaran = \App\Models\Lamaran::with(['jawaban.kriteria', 'jawaban.skala', 'pelamar'])->find($h['lamaran_id']); 
                                $isSaved = isset($h['nilai_disimpan']) && (float)$h['nilai_v'] == (float)$h['nilai_disimpan'];
                                $st = $h['status_lamaran'];
                                $statusLabel = [
                                    'Proses Seleksi' => 'badge-warning text-dark',
                                    'Lolos Seleksi'  => 'badge-success',
                                    'Gagal Seleksi'  => 'badge-danger',
                                ];
                                $badge = $statusLabel[$st] ?? 'badge-secondary';
                            @endphp

                            <tr>
                                <td class="text-center font-weight-bold">{{ $rank++ }}</td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">{{ $h['pelamar'] }}</span>
                                        <button type="button" class="btn btn-xs btn-info text-white ml-2 rounded-circle" 
                                                onclick="openModal('modalJwb-{{ $h['lamaran_id'] }}')">
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
                                    <span class="badge {{ $badge }} p-2">{{ $st }}</span>
                                </td>

                                <td class="text-center align-middle">
                                    @if($lamaran) 
                                        <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm me-1">Detail</a> 
                                    @endif

                                    {{-- Tombol LOLOS --}}
                                    @if($st !== 'Lolos Seleksi')
                                        <form action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" 
                                              method="POST" class="d-inline">
                                            @csrf 
                                            <input type="hidden" name="status" value="Lolos Seleksi">
                                            <button class="btn btn-success btn-sm me-1"
                                                    onclick="return confirm('Yakin meloloskan pelamar ini?')">Lolos</button>
                                        </form>
                                    @endif

                                    {{-- Tombol WA --}}
                                    @if($st === 'Lolos Seleksi')
                                        <button class="btn btn-success btn-sm rounded-pill me-1"
                                            onclick="sendWA(
                                                '{{ $lamaran->pelamar->nomor_whatsapp }}', 
                                                '{{ $lamaran->id_lamaran }}', 
                                                '{{ $lamaran->pelamar->nama }}', 
                                                '{{ $lowongan->posisi->nama_posisi }}', 
                                                '{{ $lowongan->dealer->nama_dealer }}'
                                            )">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </button>
                                    @endif

                                    {{-- Tombol GAGAL --}}
                                    @if($st !== 'Gagal Seleksi')
                                        <form action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" 
                                              method="POST" class="d-inline">
                                            @csrf 
                                            <input type="hidden" name="status" value="Gagal Seleksi">
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin menggagalkan pelamar ini?')">Gagal</button>
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
</div>

{{-- Modal Jawaban --}}
@foreach ($hasil_akhir as $h)
    @php $lamaran = \App\Models\Lamaran::with(['jawaban.kriteria', 'jawaban.skala'])->find($h['lamaran_id']); @endphp
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
                                <th>No</th>
                                <th>Kriteria</th>
                                <th>Jawaban</th>
                                <th class="text-center">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($lamaran)
                                @foreach($lamaran->jawaban as $jb)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jb->kriteria->nama_kriteria ?? '-' }}</td>
                                        <td>{{ $jb->skala->deskripsi ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ $jb->nilai ?? 0 }}</td>
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

{{-- Script Modal & WA --}}
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = 'auto';
}

function sendWA(phone, id, nama, posisi, dealer) {
    // Nomor harus valid
    if (!phone) { 
        alert("Nomor HP pelamar tidak tersedia."); 
        return; 
    }

    // Hanya angka
    phone = phone.replace(/\D/g, "");
    if (phone.startsWith("0")) phone = "62" + phone.substring(1);

    // Hitung tanggal +3 hari
    let tanggal = new Date();
    tanggal.setDate(tanggal.getDate() + 3);
    let tanggalStr = tanggal.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

    // Pesan WA
    let message = `Yth. ${nama},\n\n` +
        `Selamat! Anda dinyatakan Lolos Seleksi Tahap Awal untuk posisi *${posisi}* di *${dealer}*.\n\n` +
        `Kami mengundang Anda untuk hadir ke Main Dealer Yamaha Lautan Teduh Interniaga untuk mengikuti tahapan selanjutnya:\n\n` +
        `Alamat: Jl. Ikan Tenggiri No. 24, Teluk Betung, Bandar Lampung, Lampung, 35223\n` +
        `Tanggal: ${tanggalStr}\n` +
        `Waktu: 09.00 WIB\n\n` +
        `Mohon konfirmasi kehadiran Anda melalui pesan ini. Kehadiran Anda tepat waktu sangat kami hargai.\n\n` +
        `Terima kasih atas perhatian dan kerja samanya.\n\n` +
        `Hormat kami,\nTim HRD Yamaha Lautan Teduh Interniaga`;

    // Encode aman
    let url = "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);

    // Buka WA
    window.open(url, "_blank");
}
</script>

<style>
.custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: none; align-items: center; justify-content: center; }
.custom-modal-overlay { position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
.custom-modal-dialog { position: relative; width: 90%; max-width: 800px; background: #fff; border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
.custom-modal-header { padding: 15px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; }
.custom-modal-body { max-height: 70vh; overflow-y: auto; }
.custom-modal-footer { padding: 10px 15px; border-top: 1px solid #dee2e6; text-align: right; }
.close-btn { background: none; border: none; font-size: 1.5rem; opacity: 0.5; cursor: pointer; }
</style>

@endsection
