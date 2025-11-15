@extends('admin.layout')

@section('content')
<div class="container mt-4">

    <h3>Edit Dealer</h3>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('admin.dealer.update', $dealer->kode_dealer) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Dealer</label>
                    <input type="text" name="nama_dealer" value="{{ $dealer->nama_dealer }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" value="{{ $dealer->kota }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ $dealer->singkatan }}" class="form-control" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.dealer.index') }}" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
