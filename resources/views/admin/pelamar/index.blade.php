@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola Data Pelamar</h3>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. WhatsApp</th>
                        <th>Status Akun</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelamars as $pelamar)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pelamar->nama }}</td>
                        <td>{{ $pelamar->email }}</td>
                        <td>{{ $pelamar->nomor_whatsapp }}</td>
                        <td>
                            @if($pelamar->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pelamar.show', $pelamar->id_pelamar) }}" 
                                class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ route('admin.pelamar.toggleStatus', $pelamar->id_pelamar) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Anda yakin ingin mengubah status akun ini?')">
                                @csrf
                                @if($pelamar->is_active)
                                    <button class="btn btn-danger btn-sm">Nonaktifkan</button>
                                @else
                                    <button class="btn btn-success btn-sm">Aktifkan</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data pelamar yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection