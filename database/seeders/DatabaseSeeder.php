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
        $this->call([
            AdminSeeder::class,
            DealerSeeder::class,
        ]);

        $this->command->info('🧠 Seeding Master Data Tes...');
        
        $this->call([
            // 1. Jenis Tes (Papikostik & Kepribadian)
            JenisTesSeeder::class,
            
            // 2. Aspek & Dimensi
            PapikostikAspekSeeder::class,
            KepribadianDimensiSeeder::class,
            
            // 3. Soal Dummy (10 soal masing-masing)
            SoalPapikostikDummySeeder::class,
            SoalKepribadianDummySeeder::class,
        ]);
    }
}
