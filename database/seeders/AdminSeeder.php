<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::truncate();

        // 1. Akun Super Admin
        Admin::create([
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'role' => 'SUPER_ADMIN', // Tetap
            'is_active' => true,
        ]);

        // 2. Akun HRD (FIXED)
        Admin::create([
            'username' => 'hrd', // Diubah dari hrdpusat
            'password' => Hash::make('password'),
            'role' => 'HRD', // Diubah dari HR_PUSAT
            'is_active' => true,
        ]);
    }
}