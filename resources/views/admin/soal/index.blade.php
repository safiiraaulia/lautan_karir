@extends('layouts.admin')

@section('title', 'Kelola Bank Soal')

@section('content')
<style>
    .table-custom {
        font-size: 12px; 
    }
    .table-custom th, .table-custom td {
        padding: 6px 10px !important; 
        vertical-align: middle !important;
    }

    .table-custom thead th {
        text-align: center !important;
        background-color: #113883 !important;
        border: 1px solid #0a2b66 !important; 
        vertical-align: middle !important;
    }
</style>

<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">Kelola Bank Soal</h3>
            <p class="text-muted small mb-0">Manajemen instrumen tes untuk rekrutmen PT. Lautan Teduh Interniaga.</p>
        </div>
        
        <div class="d-flex" style="gap: 10px;">
            <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalTambahPapi">
                <i class="fas fa-plus mr-1"></i> Tambah Soal PAPI
            </button>
            <button class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#modalTambahKepribadian">
                <i class="fas fa-plus mr-1"></i> Tambah Soal Kepribadian
            </button>
        </div>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header p-0 pt-1 border-bottom-0 bg-light">
            <ul class="nav nav-tabs pl-3" id="custom-tabs-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold text-primary small" id="custom-tabs-papi-tab" data-toggle="pill" href="#custom-tabs-papi" role="tab">
                        Papikostik ({{ $soals->where('tipe_soal', 'papikostik')->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-success small" id="custom-tabs-kepribadian-tab" data-toggle="pill" href="#custom-tabs-kepribadian" role="tab">
                        Kepribadian DISC ({{ $soals->where('tipe_soal', 'disc')->count() }})
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-tabContent">
                
                {{-- TAB PAPIKOSTIK --}}
                <div class="tab-pane fade show active" id="custom-tabs-papi" role="tabpanel">
                    <div class="mb-3 small text-muted d-flex align-items-center">
                        <i class="fas fa-info-circle text-info mr-2"></i> 
                        <span>Soal <strong>PAPI</strong> terdiri dari 2 pernyataan berpasangan (A dan B).</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm table-custom align-middle">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Pernyataan A</th>
                                    <th>Pernyataan B</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soals->where('tipe_soal', 'papikostik') as $soal)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $soal->nomor_kelompok }}</td>
                                    @foreach($soal->opsiJawaban as $opsi)
                                    <td>
                                        {{ $opsi->isi_opsi }} <br>
                                        <span class="badge badge-light border text-primary" style="font-size: 9px;">Aspek: {{ $opsi->kode_aspek }}</span>
                                    </td>
                                    @endforeach
                                    <td class="text-center">
                                        <a href="{{ route('admin.bank-soal.edit', $soal->id_soal_kelompok) }}" class="btn btn-warning btn-xs shadow-sm">
                                             Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs shadow-sm" 
                                                onclick="confirmDelete('{{ $soal->id_soal_kelompok }}', 'Soal PAPI No. {{ $soal->nomor_kelompok }}')">
                                            Hapus
                                        </button>
                                        <form id="form-delete-{{ $soal->id_soal_kelompok }}" action="{{ route('admin.bank-soal.destroy', $soal->id_soal_kelompok) }}" method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB DISC --}}
                <div class="tab-pane fade" id="custom-tabs-kepribadian" role="tabpanel">
                    <div class="mb-3 small text-muted d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary mr-2"></i> 
                        <span>Format: <strong>Most & Least</strong>. Satu nomor terdiri dari 4 pernyataan.</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm table-custom align-middle">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Kelompok Pernyataan (4 Opsi)</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soals->where('tipe_soal', 'disc') as $soal)
                                <tr>
                                    <td class="text-center font-weight-bold">{{ $soal->nomor_kelompok }}</td>
                                    <td>
                                        <div class="row m-0">
                                            @foreach($soal->opsiJawaban as $opsi)
                                            <div class="col-md-6 p-1">
                                                <div class="border px-2 py-1 bg-white rounded small" style="font-size: 10px; line-height: 1.2;">
                                                    <strong class="text-muted text-uppercase">Opsi {{ $opsi->kode_aspek }}:</strong> {{ $opsi->isi_opsi }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.bank-soal.edit', $soal->id_soal_kelompok) }}" class="btn btn-warning btn-xs shadow-sm">
                                             Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs shadow-sm" 
                                                onclick="confirmDelete('{{ $soal->id_soal_kelompok }}', 'Soal DISC No. {{ $soal->nomor_kelompok }}')">
                                             Hapus
                                        </button>
                                        <form id="form-delete-{{ $soal->id_soal_kelompok }}" action="{{ route('admin.bank-soal.destroy', $soal->id_soal_kelompok) }}" method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH PAPI --}}
<div class="modal fade" id="modalTambahPapi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.bank-soal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_tes_id" value="2">
                <div class="modal-header bg-primary text-white py-2">
                    <h6 class="modal-title font-weight-bold">Tambah Soal PAPI Kostick</h6>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small">Nomor Urut Soal</label>
                        <input type="number" name="nomor_kelompok" class="form-control form-control-sm" required placeholder="Contoh: 1">
                    </div>
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h6 class="text-primary font-weight-bold mb-2 text-center small">Pernyataan A</h6>
                            <textarea name="isi_opsi[]" class="form-control form-control-sm" rows="3" placeholder="Isi kalimat A..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger font-weight-bold mb-2 text-center small">Pernyataan B</h6>
                            <textarea name="isi_opsi[]" class="form-control form-control-sm" rows="3" placeholder="Isi kalimat B..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4">Simpan Soal PAPI</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH DISC --}}
<div class="modal fade" id="modalTambahKepribadian" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.bank-soal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_tes_id" value="1">
                <div class="modal-header bg-success text-white py-2">
                    <h6 class="modal-title font-weight-bold">Tambah Soal Kepribadian (DISC)</h6>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold small">Nomor Urut Soal</label>
                        <input type="number" name="nomor_kelompok" class="form-control form-control-sm" required>
                    </div>
                    <div class="row">
                        @foreach(['D', 'I', 'S', 'C'] as $label)
                        <div class="col-md-6 mb-2">
                            <div class="card card-body bg-light border-0 py-2 px-3">
                                <h6 class="font-weight-bold text-dark extra-small mb-1">Pernyataan {{ $label }}</h6>
                                <textarea name="isi_opsi[]" class="form-control form-control-sm" rows="2" placeholder="Masukkan pernyataan..." required></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm px-4">Simpan Soal Kepribadian</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id, label) {
        Swal.fire({
            title: 'Hapus Soal?',
            html: `Apakah Anda yakin ingin menghapus <strong>${label}</strong>? Tindakan ini tidak bisa dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection