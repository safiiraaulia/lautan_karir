@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Kelola Data Pelamar</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. WhatsApp</th>
                        <th class="text-center">Status Akun</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelamars as $pelamar)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $pelamar->nama }}</td>
                        <td>{{ $pelamar->email }}</td>
                        <td>{{ $pelamar->nomor_whatsapp }}</td>
                        <td class="text-center">
                            @if($pelamar->is_active)
                                <span class="badge bg-success px-3">Aktif</span>
                            @else
                                <span class="badge bg-danger px-3">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.pelamar.show', $pelamar->id_pelamar) }}" class="btn btn-info btn-sm">Detail</a>
                            
                            {{-- MODIFIKASI: Tombol Toggle Status dengan Konfirmasi SweetAlert --}}
                            <form id="form-toggle-{{ $pelamar->id_pelamar }}" action="{{ route('admin.pelamar.toggleStatus', $pelamar->id_pelamar) }}" method="POST" class="d-inline">
                                @csrf
                                @if($pelamar->is_active)
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmToggle('{{ $pelamar->id_pelamar }}', 'nonaktifkan', '{{ $pelamar->nama }}')">Nonaktifkan</button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm" onclick="confirmToggle('{{ $pelamar->id_pelamar }}', 'aktifkan', '{{ $pelamar->nama }}')">Aktifkan</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Data pelamar belum terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmToggle(id, aksi, nama) {
        const isAktifkan = aksi === 'aktifkan';
        Swal.fire({
            title: isAktifkan ? 'Aktifkan Akun?' : 'Nonaktifkan Akun?',
            text: `Anda yakin ingin mengubah status akun ${nama}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: isAktifkan ? '#28a745' : '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-toggle-${id}`).submit();
            }
        });
    }
</script>
@endsection