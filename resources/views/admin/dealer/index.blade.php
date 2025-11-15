@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Master Dealer</h3>
        <a href="{{ route('admin.dealer.create') }}" class="btn btn-primary">+ Tambah Dealer</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Dealer</th>
                        <th>Nama Dealer</th>
                        <th>Kota</th>
                        <th>Singkatan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($dealer as $row)
                        <tr>
                            <td>{{ $row->kode_dealer }}</td>
                            <td>{{ $row->nama_dealer }}</td>
                            <td>{{ $row->kota }}</td>
                            <td>{{ $row->singkatan }}</td>

                            <td>
                                <a href="{{ route('admin.dealer.edit', $row->kode_dealer) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.dealer.destroy', $row->kode_dealer) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
