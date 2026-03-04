<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rule; 

class UserController extends Controller
{

    public function index()
    {
        $users = Admin::where('id_admin', '!=', auth('admin')->id())->get(); 
        
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
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

    public function edit(Admin $user) 
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, Admin $user)
    {
        $request->validate([
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('admins')->ignore($user->id_admin, 'id_admin')
            ],
            'role' => 'required|in:SUPER_ADMIN,HRD',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only('username', 'role', 'is_active');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User admin berhasil diperbarui.');
    }

    public function destroy(Admin $user)
    {
        if ($user->id_admin == auth('admin')->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri.']);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User admin berhasil dihapus.');
    }
}