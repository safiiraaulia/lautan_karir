@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit Master Dealer</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.dealer.update', $dealer->kode_dealer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="kode_dealer">Kode Dealer</label>
                    <input type="text" class="form-control" id="kode_dealer" 
                           value="{{ $dealer->kode_dealer }}" readonly disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="nama_dealer">Nama Dealer</label>
                    <input type="text" class="form-control @error('nama_dealer') is-invalid @enderror" 
                           id="nama_dealer" name="nama_dealer" value="{{ old('nama_dealer', $dealer->nama_dealer) }}">
                    @error('nama_dealer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="kota">Kota</label>
                    <input type="text" class="form-control @error('kota') is-invalid @enderror" 
                           id="kota" name="kota" value="{{ old('kota', $dealer->kota) }}">
                    @error('kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="singkatan">Singkatan</label>
                    <input type="text" class="form-control @error('singkatan') is-invalid @enderror" 
                           id="singkatan" name="singkatan" value="{{ old('singkatan', $dealer->singkatan) }}">
                    @error('singkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.dealer.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection