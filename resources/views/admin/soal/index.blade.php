@extends('layouts.admin')

@section('title', 'Kelola Bank Soal')

@section('content')
<div class="container-fluid mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-0">Kelola Bank Soal</h3>
            <p class="text-muted small mb-0">Manajemen instrumen tes untuk rekrutmen PT. Lautan Teduh Interniaga.</p>
        </div>
        
        <div class="d-flex" style="gap: 10px;">
            <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalTambahPapi">
                <i class="fas fa-plus"></i> Tambah Soal PAPI
            </button>
            <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#modalTambahKepribadian">
                <i class="fas fa-plus"></i> Tambah Soal Kepribadian
            </button>
        </div>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header p-0 pt-1 border-bottom-0 bg-light">
            <ul class="nav nav-tabs pl-3" id="custom-tabs-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold text-primary" id="custom-tabs-papi-tab" data-toggle="pill" href="#custom-tabs-papi" role="tab">
                        Papikostik ({{ $soals->where('tipe_soal', 'papikostik')->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold text-success" id="custom-tabs-kepribadian-tab" data-toggle="pill" href="#custom-tabs-kepribadian" role="tab">
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
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Pernyataan A</th>
                                    <th>Pernyataan B</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soals->where('tipe_soal', 'papikostik') as $soal)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $soal->nomor_kelompok }}</td>
                                    @foreach($soal->opsiJawaban as $opsi)
                                    <td>
                                        {{ $opsi->isi_opsi }} <br>
                                        <span class="badge badge-light border text-primary">Aspek: {{ $opsi->kode_aspek }}</span>
                                    </td>
                                    @endforeach
                                    <td class="text-center align-middle">
                                        <a href="{{ route('admin.bank-soal.edit', $soal->id_soal_kelompok) }}" class="btn btn-warning btn-sm shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm shadow-sm" 
                                                onclick="confirmDelete('{{ $soal->id_soal_kelompok }}', 'Soal PAPI No. {{ $soal->nomor_kelompok }}')">
                                            <i class="fas fa-trash"></i>
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
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    {{-- Ukuran kolom tetap sesuai kode awal Anda --}}
                                    <th width="5%">No</th>
                                    <th>Kelompok Pernyataan (4 Opsi)</th>
                                    <th width="12%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soals->where('tipe_soal', 'disc') as $soal)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold">{{ $soal->nomor_kelompok }}</td>
                                    <td>
                                        <div class="row">
                                            @foreach($soal->opsiJawaban as $opsi)
                                            <div class="col-md-6 mb-2">
                                                <div class="border p-2 bg-white rounded small shadow-sm">
                                                    <small class="font-weight-bold text-muted text-uppercase">Pernyataan {{ $opsi->kode_aspek }}</small><br>
                                                    {{ $opsi->isi_opsi }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('admin.bank-soal.edit', $soal->id_soal_kelompok) }}" class="btn btn-warning btn-sm shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm shadow-sm" 
                                                onclick="confirmDelete('{{ $soal->id_soal_kelompok }}', 'Soal DISC No. {{ $soal->nomor_kelompok }}')">
                                            <i class="fas fa-trash"></i>
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
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Soal PAPI Kostick</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Nomor Urut Soal</label>
                        <input type="number" name="nomor_kelompok" class="form-control" required placeholder="Contoh: 1">
                    </div>
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h6 class="text-primary font-weight-bold mb-2 text-center">Pernyataan A</h6>
                            <textarea name="isi_opsi[]" class="form-control" rows="3" placeholder="Isi kalimat A..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger font-weight-bold mb-2 text-center">Pernyataan B</h6>
                            <textarea name="isi_opsi[]" class="form-control" rows="3" placeholder="Isi kalimat B..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Soal PAPI</button>
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
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Soal Kepribadian (DISC)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Nomor Urut Soal</label>
                        <input type="number" name="nomor_kelompok" class="form-control" required>
                    </div>
                    <div class="row">
                        @foreach(['D', 'I', 'S', 'C'] as $label)
                        <div class="col-md-6 mb-3">
                            <div class="card card-body bg-light border-0 py-2">
                                <h6 class="font-weight-bold text-dark small">Pernyataan {{ $label }}</h6>
                                <textarea name="isi_opsi[]" class="form-control" rows="2" placeholder="Masukkan pernyataan..." required></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Simpan Soal Kepribadian</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT --}}
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