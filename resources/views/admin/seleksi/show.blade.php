@extends('layouts.admin')

@section('title', 'Hasil SAW: ' . $lowongan->posisi->nama_posisi)

@section('content')

<style>
    /* Desain Header Utama: Navy, Tulisan Putih, Font 10px */
    .table thead th {
        font-size: 10px; 
        white-space: nowrap; 
        vertical-align: middle !important;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        padding: 12px 5px !important;
        background-color: #113883 !important;
        color: white !important;
    }

    .badge-soft {
        font-weight: 600; padding: 0.35rem 0; border-radius: 6px; font-size: 10px;
        text-transform: uppercase; display: inline-block; width: 85px; text-align: center;
        border: 1px solid transparent; line-height: 1; vertical-align: middle;
    }
    .badge-v { width: 65px !important; }
    .badge-soft-success { background-color: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }
    .badge-soft-danger  { background-color: #ffebee; color: #c62828; border-color: #ffcdd2; }
    .badge-soft-warning { background-color: #fff8e1; color: #f57f17; border-color: #ffecb3; }
    .badge-soft-dark    { background-color: #f8f9fa; color: #012951; border-color: #dee2e6; }

    .custom-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: none; align-items: center; justify-content: center; }
    .custom-modal-overlay { position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .custom-modal-dialog { position: relative; width: 95%; max-width: 700px; background: #fff; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); overflow: hidden; }
    
    /* MODAL HEADER: Diubah jadi Putih & Border tipis */
    .custom-modal-header { 
        padding: 15px; 
        border-bottom: 1px solid #dee2e6; 
        background: #ffffff; /* Putih */
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .close-btn { background: none; border: none; font-size: 1.5rem; color: #333; cursor: pointer; }

    .card-dark.card-outline { border-top: 3px solid #113883; }
</style>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-dark mb-0 fw-bold">Hasil Perangkingan SAW</h3>
            <p class="text-muted small mb-0">Daftar pelamar diurutkan berdasarkan skor tertinggi (Otomatis Terupdate).</p>
        </div>
        <div>
            <a href="{{ route('admin.seleksi.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

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
                    <p class="mb-1 text-muted small">Periode:</p>
                    <p class="fw-bold text-dark small">{{ $lowongan->tgl_buka->format('d F Y') }} — {{ $lowongan->tgl_tutup->format('d F Y') }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p class="mb-1 text-muted small">Kriteria & Bobot:</p>
                    <div>
                        @foreach($kriterias as $k) 
                            <span class="badge mr-1 mb-1 p-2 text-white" style="font-size: 10px; background-color: #113883; border-radius: 4px;">
                                {{ $k->nama_kriteria }} 
                                <span class="badge badge-light ml-1 text-dark" style="font-size: 9px;">{{ $k->pivot->bobot_saw }}</span>
                            </span> 
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-top border-dark">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="40">NO</th>
                            <th class="text-left">NAMA PELAMAR</th>
                            <th width="80">NILAI (V)</th>
                            <th width="120">STATUS TES</th>
                            <th width="110">STATUS SELEKSI</th>
                            <th width="240">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hasil_akhir as $index => $h)
                            @php 
                                $lamaran = \App\Models\Lamaran::find($h['lamaran_id']); 
                                $st = $h['status_lamaran'];
                                $softBadgeClass = match(true) {
                                    str_contains($st, 'Lolos') => 'badge-soft-success',
                                    str_contains($st, 'Gagal') => 'badge-soft-danger',
                                    default => 'badge-soft-warning',
                                };
                            @endphp
                            <tr>
                                <td class="text-center font-weight-bold align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="font-weight-bold">{{ $h['pelamar'] }}</span>
                                        <button type="button" class="btn btn-xs btn-info text-white rounded-circle shadow-sm" 
                                                onclick="openModal('modalJwb-{{ $h['lamaran_id'] }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge-soft badge-v badge-soft-dark">
                                        {{ number_format($h['nilai_v'], 4) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge-soft {{ $h['sudah_tes'] ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                        {{ $h['sudah_tes'] ? 'Selesai' : 'Belum' }}
                                    </span>
                                    @if($h['sudah_tes'])
                                        <button type="button" class="btn btn-link btn-sm text-primary p-0 d-block mx-auto mt-1 fw-bold" 
                                                style="font-size: 9px; text-decoration: none;"
                                                onclick="openModal('modalKesimpulan-{{ $h['lamaran_id'] }}')">
                                            <i class="fas fa-edit mr-1"></i> Kesimpulan
                                        </button>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge-soft {{ $softBadgeClass }}">
                                        {{ str_replace(' Seleksi', '', $st) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle" style="white-space: nowrap;">
                                    @if($lamaran) 
                                        <a href="{{ route('admin.pelamar.show', $lamaran->pelamar_id) }}" target="_blank" class="btn btn-info btn-xs d-inline-block shadow-sm">Detail</a> 
                                    @endif

                                    @if($h['sudah_tes'])
                                        @if($st !== 'Lolos Seleksi')
                                            <form id="form-lolos-{{ $h['lamaran_id'] }}" action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" method="POST" class="d-inline">
                                                @csrf 
                                                <input type="hidden" name="status" value="Lolos Seleksi">
                                                <button type="button" class="btn btn-success btn-xs shadow-sm" onclick="confirmStatus('lolos', '{{ $h['lamaran_id'] }}', '{{ $h['pelamar'] }}')">Lolos</button>
                                            </form>
                                        @else
                                            <button class="btn btn-success btn-xs rounded-pill d-inline-block shadow-sm" onclick="sendWA('{{ $lamaran->pelamar->nomor_whatsapp }}', '{{ $h['pelamar'] }}', '{{ $lowongan->posisi->nama_posisi }}', '{{ $lowongan->dealer->nama_dealer }}')">
                                                <i class="fab fa-whatsapp"></i> WA
                                            </button>
                                        @endif

                                        @if($st !== 'Gagal Seleksi')
                                            <form id="form-gagal-{{ $h['lamaran_id'] }}" action="{{ route('admin.seleksi.updateStatus', $h['lamaran_id']) }}" method="POST" class="d-inline">
                                                @csrf 
                                                <input type="hidden" name="status" value="Gagal Seleksi">
                                                <button type="button" class="btn btn-danger btn-xs shadow-sm" onclick="confirmStatus('gagal', '{{ $h['lamaran_id'] }}', '{{ $h['pelamar'] }}')">Gagal</button>
                                            </form> 
                                        @endif
                                    @else
                                        <span class="text-muted italic" style="font-size: 10px;">Menunggu Tes Psikotes</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted small">Data pelamar belum tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL JAWABAN & MODAL KESIMPULAN --}}
@foreach ($hasil_akhir as $h)
    {{-- Modal Jawaban Administrasi --}}
    <div class="custom-modal" id="modalJwb-{{ $h['lamaran_id'] }}">
        <div class="custom-modal-overlay" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')"></div>
        <div class="custom-modal-dialog">
            {{-- PERBAIKAN: Header Putih & Font Hitam --}}
            <div class="custom-modal-header">
                <h5 class="modal-title small fw-bold text-dark">Jawaban Administrasi: {{ $h['pelamar'] }}</h5>
                <button type="button" class="close-btn" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')">&times;</button>
            </div>
            <div class="custom-modal-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="bg-navy text-white small">
                        <tr>
                            <th width="40" class="text-white" style="border: 1px solid #0a2b66 !important; background-color: #113883 !important;">NO</th>
                            <th class="text-white" style="border: 1px solid #0a2b66 !important; background-color: #113883 !important;">KRITERIA</th>
                            <th class="text-white" style="border: 1px solid #0a2b66 !important; background-color: #113883 !important;">JAWABAN</th>
                            <th width="60" class="text-center text-white" style="border: 1px solid #0a2b66 !important; background-color: #113883 !important;">NILAI</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @php $dl = \App\Models\Lamaran::with('jawaban.kriteria', 'jawaban.skala')->find($h['lamaran_id']); @endphp
                        @foreach($dl->jawaban as $jb)
                            <tr>
                                <td class="text-center text-dark">{{ $loop->iteration }}</td>
                                <td class="text-dark">{{ $jb->kriteria->nama_kriteria }}</td>
                                {{-- Memanggil deskripsi jawaban dari formulir public --}}
                                <td class="text-dark">{{ $jb->skala->deskripsi ?? '-' }}</td> 
                                <td class="text-center fw-bold text-dark">{{ $jb->nilai }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-2 text-right bg-light border-top">
                <button type="button" class="btn btn-secondary btn-xs px-3" onclick="closeModal('modalJwb-{{ $h['lamaran_id'] }}')">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Kesimpulan Psikotes --}}
    <div class="custom-modal" id="modalKesimpulan-{{ $h['lamaran_id'] }}">
        <div class="custom-modal-overlay" onclick="closeModal('modalKesimpulan-{{ $h['lamaran_id'] }}')"></div>
        <div class="custom-modal-dialog">
            <form action="{{ route('admin.seleksi.updateKesimpulan', $h['lamaran_id']) }}" method="POST">
                @csrf @method('PUT')
                {{-- PERBAIKAN: Header Putih & Font Hitam --}}
                <div class="custom-modal-header">
                    <h6 class="modal-title fw-bold text-dark">Kesimpulan Hasil Psikotes: {{ $h['pelamar'] }}</h6>
                    <button type="button" class="close-btn" onclick="closeModal('modalKesimpulan-{{ $h['lamaran_id'] }}')">&times;</button>
                </div>
                <div class="p-3">
                    <div class="form-group mb-3">
                        <label class="small fw-bold text-muted mb-1 text-uppercase">Hasil Analisis DISC:</label>
                        <textarea name="kesimpulan_disc" class="form-control form-control-sm border-navy" rows="3" required>{{ $h['kesimpulan_disc'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="small fw-bold text-muted mb-1 text-uppercase">Hasil Analisis Papikostik:</label>
                        <textarea name="kesimpulan_papi" class="form-control form-control-sm border-navy" rows="3" required>{{ $h['kesimpulan_papi'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="p-3 bg-light text-right">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal('modalKesimpulan-{{ $h['lamaran_id'] }}')">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm" style="background-color: #113883 !important; border:none;">Simpan Kesimpulan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = 'auto'; }

    function confirmStatus(tipe, id, nama) {
        const isLolos = tipe === 'lolos';
        Swal.fire({
            title: isLolos ? 'Loloskan Pelamar?' : 'Gagalkan Pelamar?',
            text: `Apakah Anda yakin ingin mengubah status ${nama}?`,
            icon: isLolos ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: '#113883',
            confirmButtonText: 'Ya, Lanjutkan!'
        }).then((result) => { if (result.isConfirmed) { document.getElementById(`form-${tipe}-${id}`).submit(); } });
    }

    function sendWA(phone, nama, posisi, dealer) {
        if (!phone) return Swal.fire('Error', 'Nomor tidak tersedia', 'error');
        phone = phone.replace(/\D/g, ""); if (phone.startsWith("0")) phone = "62" + phone.substring(1);
        let msg = `Yth. ${nama},\n\nSelamat! Anda dinyatakan Lolos Seleksi Tahap Awal posisi *${posisi}* di *${dealer}*.`;
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(msg)}`, "_blank");
    }
</script>
@endsection