@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Kelola User Admin</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah User</a>
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
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id_admin) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id_admin) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus user {{ $user->username }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data user admin selain Anda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection