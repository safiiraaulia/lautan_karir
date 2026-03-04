@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="mb-4">
        <a href="{{ route('admin.bank-soal.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header py-3 bg-warning">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-edit me-2"></i> Edit Soal {{ $soal->jenisTes->nama_tes }} - Nomor {{ $soal->nomor_kelompok }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bank-soal.update', $soal->id_soal_kelompok) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label class="fw-bold">Nomor Urut Soal</label>
                    <input type="number" name="nomor_kelompok" class="form-control" value="{{ $soal->nomor_kelompok }}" required>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2 text-navy">Isi Pernyataan</h5>
                <div class="row">
                    @foreach($soal->opsiJawaban as $index => $opsi)
                    <div class="col-md-6 mb-3">
                        <div class="card card-body bg-light border-0 shadow-sm">
                            <label class="fw-bold text-primary">Pernyataan {{ $opsi->kode_aspek }}</label>
                            
                            <input type="hidden" name="opsi_id[]" value="{{ $opsi->id_opsi_jawaban }}">
                            
                            <textarea name="isi_opsi[]" class="form-control" rows="3" required placeholder="Masukkan isi pernyataan...">{{ $opsi->isi_opsi }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 border-top pt-3 text-right">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection