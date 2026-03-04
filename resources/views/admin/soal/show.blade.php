@extends('layouts.admin')

@section('title', 'Kelola Soal')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.bank-soal.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                Detail Soal: {{ $kelompok->jenisTes->nama_tes }} - Nomor {{ $kelompok->nomor_kelompok }}
            </h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Jenis Tes</th>
                            <td>: {{ $kelompok->jenisTes->nama_tes }}</td>
                        </tr>
                        <tr>
                            <th>Tipe Soal</th>
                            <td>: <span class="badge badge-warning text-uppercase">{{ $kelompok->tipe_soal ?? $kelompok->jenisTes->nama_tes }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5 class="font-weight-bold mb-3">Daftar Pernyataan / Opsi Jawaban:</h5>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th width="80">Label</th>
                            <th>Isi Pernyataan</th>
                            <th width="150">Kode Aspek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelompok->opsiJawaban as $opsi)
                        <tr>
                            <td class="font-weight-bold text-primary">
                                {{ $loop->iteration }}.
                            </td>
                            <td>{{ $opsi->isi_opsi }}</td>
                            <td>
                                <span class="badge badge-dark">{{ $opsi->kode_aspek }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection