@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Pelamar: {{ $pelamar->nama }}</h3>
        <a href="{{ route('admin.pelamar.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($pelamar->foto)
                        <img src="{{ Storage::url($pelamar->foto) }}" 
                             alt="Foto Pelamar" class="img-fluid rounded mb-3" 
                             style="width: 100%; max-width: 300px; height: auto; border: 1px solid #ddd;">
                    @else
                        <div class="border p-3 text-center text-muted" style="height: 300px; width: 100%; max-width: 300px; display: flex; align-items: center; justify-content: center;">
                            <span>Foto tidak tersedia</span>
                        </div>
                    @endif
                    
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nama:</strong> {{ $pelamar->nama }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $pelamar->email }}</li>
                        <li class="list-group-item"><strong>No. WA:</strong> {{ $pelamar->nomor_whatsapp }}</li>
                        <li class="list-group-item"><strong>No. KTP:</strong> {{ $pelamar->no_ktp ?? '-' }}</li>
                        <li class="list-group-item"><strong>Status Akun:</strong> 
                            @if($pelamar->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="col-md-8">
                    <h4>Berkas Administrasi</h4>
                    <p>Klik link untuk melihat/mengunduh berkas yang di-upload oleh pelamar.</p>
                    
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Berkas</th>
                                <th>Link Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CV (Curriculum Vitae)</td>
                                <td>
                                    @if($pelamar->path_cv)
                                        <a href="{{ Storage::url($pelamar->path_cv) }}" target="_blank" class="btn btn-primary btn-sm">Lihat CV</a>
                                    @else
                                        <span class="text-muted">Belum di-upload</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>KTP</td>
                                <td>
                                    @if($pelamar->path_ktp)
                                        <a href="{{ Storage::url($pelamar->path_ktp) }}" target="_blank" class="btn btn-primary btn-sm">Lihat KTP</a>
                                    @else
                                        <span class="text-muted">Belum di-upload</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Ijazah Terakhir</td>
                                <td>
                                    @if($pelamar->path_ijazah)
                                        <a href="{{ Storage::url($pelamar->path_ijazah) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Ijazah</a>
                                    @else
                                        <span class="text-muted">Belum di-upload</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Kartu Keluarga (KK)</td>
                                <td>
                                    @if($pelamar->path_kk)
                                        <a href="{{ Storage::url($pelamar->path_kk) }}" target="_blank" class="btn btn-primary btn-sm">Lihat KK</a>
                                    @else
                                        <span class="text-muted">Belum di-upload</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Surat Lamaran Kerja</td>
                                <td>
                                    @if($pelamar->path_lamaran)
                                        <a href="{{ Storage::url($pelamar->path_lamaran) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Surat Lamaran</a>
                                    @else
                                        <span class="text-muted">Belum di-upload</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection