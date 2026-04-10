@extends('layouts.admin')

@section('title', 'Kelola User Admin')

@section('content')
<style>
   
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
</style>

<div class="container-fluid mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight text-dark mb-0">Kelola User Admin</h3>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm btn-sm px-3">
            <i class="fas fa-plus mr-1"></i> Tambah User
        </a>
    </div>

    {{-- Alert Success/Error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show small" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0 card-black-outline">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm table-custom mb-0 align-middle">
                    <thead>
                        <tr>
                            <th width="50">NO</th>
                            <th>USERNAME</th>
                            <th>ROLE</th>
                            <th width="120">STATUS</th>
                            <th width="150">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $user->username }}</td>
                            <td class="text-center">
                                <span class="badge bg-light border text-dark px-2">{{ $user->role }}</span>
                            </td>
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="badge bg-success px-3 py-1 rounded-pill shadow-sm" style="font-size: 9px;">AKTIF</span>
                                @else
                                    <span class="badge bg-danger px-3 py-1 rounded-pill shadow-sm" style="font-size: 9px;">NON-AKTIF</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id_admin) }}" class="btn btn-warning btn-xs px-2 shadow-sm">
                                     Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id_admin) }}"
                                      method="POST" class="d-inline"
                                      id="delete-form-{{ $user->id_admin }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-xs px-2 shadow-sm" 
                                            onclick="confirmDelete('{{ $user->id_admin }}', '{{ $user->username }}')">
                                         Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Belum ada data user admin selain Anda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function confirmDelete(id, username) {
        Swal.fire({
            title: 'Hapus User?',
            html: `Yakin ingin menghapus user <strong>${username}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection