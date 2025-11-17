<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin; // <-- Gunakan Model Admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Gunakan Hash untuk password
use Illuminate\Validation\Rule; // <-- Gunakan Rule untuk validasi

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user admin.
     */
    public function index()
    {
        // Ambil semua admin, kecuali diri sendiri (opsional)
        $users = Admin::where('id_admin', '!=', auth('admin')->id())->get();
        // Jika ingin menampilkan semua termasuk diri sendiri:
        // $users = Admin::all(); 
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user admin baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user admin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username',
            'role' => 'required|in:SUPER_ADMIN,HRD',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User admin baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit user admin.
     */
    public function edit(Admin $user) // Laravel akan otomatis mencari Admin berdasarkan ID
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user admin.
     */
    public function update(Request $request, Admin $user)
    {
        $request->validate([
            'username' => [
                'required', 'string', 'max:255',
                // Pastikan username unik, KECUALI untuk user ini sendiri
                Rule::unique('admins')->ignore($user->id_admin, 'id_admin')
            ],
            'role' => 'required|in:SUPER_ADMIN,HRD',
            'is_active' => 'required|boolean',
            // Password opsional, hanya di-update jika diisi
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Siapkan data untuk di-update
        $data = $request->only('username', 'role', 'is_active');

        // Jika password diisi, hash dan tambahkan ke data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User admin berhasil diperbarui.');
    }

    /**
     * Hapus user admin.
     */
    public function destroy(Admin $user)
    {
        // Pencegahan agar tidak bisa hapus diri sendiri
        if ($user->id_admin == auth('admin')->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri.']);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User admin berhasil dihapus.');
    }
}