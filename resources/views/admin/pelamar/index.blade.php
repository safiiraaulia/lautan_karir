@extends('layouts.admin')

@section('title', 'Kelola Data Pelamar')

@section('content')
{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    .table-custom {
        font-size: 12px;
        color: #333;
    }

    .table-custom th, .table-custom td {
        padding: 8px 10px !important;
        vertical-align: middle !important;
    }

    .table-custom thead th {
        text-align: center !important;
        background-color: #113883 !important;
        color: white !important;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: 1px solid #0a2b66 !important;
    }

    .table-custom tbody td {
        border: 1px solid #dee2e6;
    }

    .dataTables_filter input {
        height: 30px;
        font-size: 12px;
    }
</style>

<div class="container-fluid mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold text-dark mb-0">Kelola Data Pelamar</h3>
    </div>

    <div class="card shadow mb-4 card-black-outline">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle" id="pelamarTable">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>NAMA PELAMAR</th>
                            <th>EMAIL</th>
                            <th width="160">NO. WHATSAPP</th>
                            <th width="120">STATUS AKUN</th>
                            <th width="180">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelamars as $pelamar)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $pelamar->nama }}</td>
                            <td>{{ $pelamar->email }}</td>
                            <td class="text-center">{{ $pelamar->nomor_whatsapp }}</td>
                            <td class="text-center">
                                @if($pelamar->is_active)
                                    <span class="badge bg-success px-3 py-1 rounded-pill shadow-sm" style="font-size: 9px;">AKTIF</span>
                                @else
                                    <span class="badge bg-danger px-3 py-1 rounded-pill shadow-sm" style="font-size: 9px;">NON-AKTIF</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pelamar.show', $pelamar->id_pelamar) }}" class="btn btn-info btn-xs px-2 shadow-sm">
                                    Detail
                                </a>

                                <form id="form-toggle-{{ $pelamar->id_pelamar }}" action="{{ route('admin.pelamar.toggleStatus', $pelamar->id_pelamar) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($pelamar->is_active)
                                        <button type="button" class="btn btn-danger btn-xs px-2 shadow-sm" onclick="confirmToggle('{{ $pelamar->id_pelamar }}', 'nonaktifkan', '{{ $pelamar->nama }}')">
                                            Nonaktifkan
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success btn-xs px-2 shadow-sm" onclick="confirmToggle('{{ $pelamar->id_pelamar }}', 'aktifkan', '{{ $pelamar->nama }}')">
                                            Aktifkan
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Belum ada data pelamar yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pelamarTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ],
            "pageLength": 10,
            "order": [[ 1, "asc" ]],
            "autoWidth": false,
            "destroy": true
        });
    });

    function confirmToggle(id, aksi, nama) {
        const isAktifkan = aksi === 'aktifkan';
        Swal.fire({
            title: isAktifkan ? 'Aktifkan Akun?' : 'Nonaktifkan Akun?',
            html: `Anda yakin ingin mengubah status akun <strong>${nama}</strong>?`,
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
@endpush