@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Edit User Admin: {{ $user->username }}</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id_admin) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                           id="username" name="username" value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                        <option value="">-- Pilih Role --</option>
                        <option value="SUPER_ADMIN" {{ old('role', $user->role) == 'SUPER_ADMIN' ? 'selected' : '' }}>SUPER_ADMIN</option>
                        <option value="HRD" {{ old('role', $user->role) == 'HRD' ? 'selected' : '' }}>HRD</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <p class="text-muted">Kosongkan password jika tidak ingin mengubahnya.</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="is_active">Status</label>
                    <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection