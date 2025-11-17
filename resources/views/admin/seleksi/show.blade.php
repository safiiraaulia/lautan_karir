@extends('layouts.admin')

@section('title', 'Hasil SAW: ' . $lowongan->posisi->nama_posisi)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Hasil Perangkingan SAW</h3>
        <a href="{{ route('admin.seleksi.index') }}" class="btn btn-secondary">Kembali ke Daftar Lowongan</a>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Lowongan: {{ $lowongan->posisi->nama_posisi }} ({{ $lowongan->dealer->singkatan }})
        </div>
        <div class="card-body">
            <p><strong>Periode:</strong> {{ $lowongan->tgl_buka->format('d M Y') }} s/d {{ $lowongan->tgl_tutup->format('d M Y') }}</p>
            <p><strong>Kriteria yang Digunakan:</strong>
                @foreach($kriterias as $kriteria)
                    <span class="badge bg-primary me-1">{{ $kriteria->nama_kriteria }} (Bobot: {{ $kriteria->pivot->bobot_saw }})</span>
                @endforeach
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <h4>Tabel Hasil Perangkingan (Nilai Preferensi V)</h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="50">Ranking</th>
                        <th>Nama Pelamar</th>
                        <th>Nilai V (Akhir)</th>
                        <th>Status Lamaran</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $ranking = 1; @endphp
                    @forelse ($hasil_akhir as $hasil)
                    <tr>
                        <td>{{ $ranking++ }}</td>
                        <td>{{ $hasil['pelamar'] }}</td>
                        <td><strong>{{ $hasil['nilai_v'] }}</strong></td>
                        <td>
                            @if($hasil['status_lamaran'] == 'Lolos Administrasi')
                                <span class="badge bg-success">{{ $hasil['status_lamaran'] }}</span>
                            @elseif($hasil['status_lamaran'] == 'Gagal Administrasi')
                                <span class="badge bg-danger">{{ $hasil['status_lamaran'] }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $hasil['status_lamaran'] }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm me-1">Loloskan</a>
                            <a href="#" class="btn btn-danger btn-sm">Gagalkan</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada pelamar yang mengisi form administrasi SAW.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection