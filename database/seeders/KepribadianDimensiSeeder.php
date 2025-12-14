<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KepribadianDimensi;

class KepribadianDimensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Menggunakan Model Big Five Personality Traits:
     * - O: Openness (Keterbukaan terhadap pengalaman baru)
     * - C: Conscientiousness (Kehati-hatian dan kedisiplinan)
     * - E: Extraversion (Ekstraversi, sifat sosial)
     * - A: Agreeableness (Keramahan dan kerja sama)
     * - N: Neuroticism (Kestabilan emosi)
     * 
     * @return void
     */
    public function run()
    {
        $dimensiData = [
            [
                'kode_dimensi' => 'O',
                'nama_dimensi' => 'Openness to Experience',
                'deskripsi' => 'Keterbukaan terhadap pengalaman baru, kreativitas, dan keingintahuan',
                'model' => 'BIG_FIVE'
            ],
            [
                'kode_dimensi' => 'C',
                'nama_dimensi' => 'Conscientiousness',
                'deskripsi' => 'Kehati-hatian, kedisiplinan, keteraturan, dan orientasi pada tujuan',
                'model' => 'BIG_FIVE'
            ],
            [
                'kode_dimensi' => 'E',
                'nama_dimensi' => 'Extraversion',
                'deskripsi' => 'Ekstraversi, sifat sosial, energi, dan antusiasme',
                'model' => 'BIG_FIVE'
            ],
            [
                'kode_dimensi' => 'A',
                'nama_dimensi' => 'Agreeableness',
                'deskripsi' => 'Keramahan, kerja sama, kepercayaan, dan sikap membantu',
                'model' => 'BIG_FIVE'
            ],
            [
                'kode_dimensi' => 'N',
                'nama_dimensi' => 'Neuroticism',
                'deskripsi' => 'Kestabilan emosi, ketahanan terhadap stres, dan kecenderungan cemas',
                'model' => 'BIG_FIVE'
            ],
        ];

        foreach ($dimensiData as $data) {
            KepribadianDimensi::create($data);
        }
    }
}