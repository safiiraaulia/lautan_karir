<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisTes;

class JenisTesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_tes' => 'Papikostik',
                'instruksi' => 'Jawablah setiap pernyataan sesuai dengan kondisi diri Anda.',
                'durasi_menit' => 45,
            ],
            [
                'nama_tes' => 'Kepribadian',
                'instruksi' => 'Jawablah pertanyaan dengan jujur sesuai kepribadian Anda.',
                'durasi_menit' => 15,
            ],
        ];

        foreach ($data as $item) {
            JenisTes::updateOrCreate(
                ['nama_tes' => $item['nama_tes']],
                $item
            );
        }
    }
}
