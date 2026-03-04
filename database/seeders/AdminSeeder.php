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
            'role' => 'SUPER_ADMIN',
            'is_active' => true,
        ]);

        // 2. Akun HRD
        Admin::create([
            'username' => 'hrd',
            'password' => Hash::make('password'),
            'role' => 'HRD', 
            'is_active' => true,
        ]);
    }
}