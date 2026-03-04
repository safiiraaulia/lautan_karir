@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.bank-soal.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Tambah Kelompok Soal Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bank-soal.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_tes_id">Pilih Jenis Tes</label>
                            <select name="jenis_tes_id" id="jenis_tes_id" class="form-control @error('jenis_tes_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Tes --</option>
                                @foreach($jenisTes as $jt)
                                    <option value="{{ $jt->id_jenis_tes }}" data-nama="{{ $jt->nama_tes }}">
                                        {{ $jt->nama_tes }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_tes_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_kelompok">Nomor Kelompok / Nomor Soal</label>
                            <input type="number" name="nomor_kelompok" class="form-control @error('nomor_kelompok') is-invalid @enderror" placeholder="Contoh: 1" required>
                            @error('nomor_kelompok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="font-weight-bold mb-3">Isi Pernyataan</h5>
                <div id="opsi-container" class="row">
                    <div class="col-12">
                        <p class="text-muted">Silakan pilih Jenis Tes terlebih dahulu untuk menampilkan form input pernyataan.</p>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save"></i> Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('jenis_tes_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const namaTes = selectedOption.getAttribute('data-nama');
        const container = document.getElementById('opsi-container');
        
        container.innerHTML = ''; 

        let jumlahOpsi = 0;
        let labelOpsi = [];

        if (namaTes === 'Kepribadian') {
            jumlahOpsi = 4;
            labelOpsi = ['D', 'I', 'S', 'C'];
        } else if (namaTes === 'Papikostik') {
            jumlahOpsi = 2;
            labelOpsi = ['A', 'B'];
        }

        if (jumlahOpsi > 0) {
            for (let i = 0; i < jumlahOpsi; i++) {
                container.innerHTML += `
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Pernyataan ${labelOpsi[i]}</label>
                        <textarea name="isi_opsi[]" class="form-control" rows="2" placeholder="Masukkan teks pernyataan..." required></textarea>
                    </div>
                `;
            }
        } else {
            container.innerHTML = '<div class="col-12"><p class="text-muted">Silakan pilih Jenis Tes untuk memunculkan input.</p></div>';
        }
    });
</script>
@endpush