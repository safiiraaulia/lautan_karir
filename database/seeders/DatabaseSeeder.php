<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Data Dasar & Akses Login
        $this->call([
            AdminSeeder::class,
            DealerSeeder::class,
        ]);

        $this->command->info('🧠 Seeding Data Tes Lautan Karir...');

        // 2. Data Tes
        $this->call([
            SoalKepribadianSeeder::class, 
            
            PapikostikSeeder::class, 
        ]);
        
        $this->command->info('✅ Semua data berhasil masuk!');
    }
    }
