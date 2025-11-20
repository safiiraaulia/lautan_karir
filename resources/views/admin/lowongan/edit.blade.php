@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Lowongan</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.lowongan.update', $lowongan->id_lowongan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="posisi_id">Posisi</label>
                    <select class="form-control @error('posisi_id') is-invalid @enderror" 
                            id="posisi_id" name="posisi_id">
                        <option value="">-- Pilih Posisi --</option>
                        @foreach($posisis as $posisi)
                            <option value="{{ $posisi->kode_posisi }}" 
                                    {{ old('posisi_id', $lowongan->posisi_id) == $posisi->kode_posisi ? 'selected' : '' }}>
                                {{ $posisi->nama_posisi }}
                            </option>
                        @endforeach
                    </select>
                    @error('posisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="dealer_id">Penempatan (Dealer)</label>
                    <select class="form-control @error('dealer_id') is-invalid @enderror" 
                            id="dealer_id" name="dealer_id">
                        <option value="">-- Pilih Dealer --</option>
                        @foreach($dealers as $dealer)
                            <option value="{{ $dealer->kode_dealer }}" 
                                    {{ old('dealer_id', $lowongan->dealer_id) == $dealer->kode_dealer ? 'selected' : '' }}>
                                {{ $dealer->nama_dealer }} ({{ $dealer->kota }})
                            </option>
                        @endforeach
                    </select>
                    @error('dealer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_buka">Tanggal Buka</label>
                            <input type="date" class="form-control @error('tgl_buka') is-invalid @enderror" 
                                   id="tgl_buka" name="tgl_buka" 
                                   value="{{ old('tgl_buka', $lowongan->tgl_buka->format('Y-m-d')) }}">
                            @error('tgl_buka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tgl_tutup">Tanggal Tutup</label>
                            <input type="date" class="form-control @error('tgl_tutup') is-invalid @enderror" 
                                   id="tgl_tutup" name="tgl_tutup" 
                                   value="{{ old('tgl_tutup', $lowongan->tgl_tutup->format('Y-m-d')) }}">
                            @error('tgl_tutup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status Publikasi</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="Buka" {{ old('status', $lowongan->status) == 'Buka' ? 'selected' : '' }}>Buka (Publikasikan)</option>
                        <option value="Tutup" {{ old('status', $lowongan->status) == 'Tutup' ? 'selected' : '' }}>Tutup (Simpan sebagai Draft)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi Lowongan</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection