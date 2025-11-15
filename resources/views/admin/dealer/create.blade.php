@extends('admin.layout')

@section('content')
<div class="container mt-4">

    <h3>Tambah Dealer</h3>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('admin.dealer.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kode Dealer</label>
                    <input type="text" name="kode_dealer" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Dealer</label>
                    <input type="text" name="nama_dealer" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control" required>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.dealer.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection
