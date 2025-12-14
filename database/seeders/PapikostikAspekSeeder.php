<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PapikostikAspek;

class PapikostikAspekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Data ini berdasarkan Tes Papikostik standar William M. Marston.
     * Total 19 aspek kepribadian yang diukur.
     * 
     * Sumber: Form tes yang dilampirkan dengan huruf N, G, A, R, D, C, T, V, L, P, I, F, W, X, S, O, Z, K
     * 
     * @return void
     */
    public function run()
    {
        $aspekData = [
            // WORK DIRECTION (Arah Kerja)
            [
                'kode_aspek' => 'N',
                'nama_aspek' => 'Need to Achieve',
                'deskripsi' => 'Kebutuhan untuk berprestasi dan mencapai target yang tinggi',
                'kategori' => 'Work Direction'
            ],
            [
                'kode_aspek' => 'G',
                'nama_aspek' => 'Leadership',
                'deskripsi' => 'Kemampuan memimpin dan mengambil inisiatif',
                'kategori' => 'Work Direction'
            ],
            [
                'kode_aspek' => 'A',
                'nama_aspek' => 'Need to Control Others',
                'deskripsi' => 'Kebutuhan untuk mengontrol dan mengarahkan orang lain',
                'kategori' => 'Work Direction'
            ],
            
            // WORK STYLE (Gaya Kerja)
            [
                'kode_aspek' => 'R',
                'nama_aspek' => 'Pace',
                'deskripsi' => 'Kecepatan dalam bekerja dan mengambil keputusan',
                'kategori' => 'Work Style'
            ],
            [
                'kode_aspek' => 'D',
                'nama_aspek' => 'Organized Type',
                'deskripsi' => 'Keteraturan dan kedisiplinan dalam bekerja',
                'kategori' => 'Work Style'
            ],
            [
                'kode_aspek' => 'C',
                'nama_aspek' => 'Need to Finish Task',
                'deskripsi' => 'Kebutuhan untuk menyelesaikan tugas sampai tuntas',
                'kategori' => 'Work Style'
            ],
            [
                'kode_aspek' => 'Z',
                'nama_aspek' => 'Need for Change',
                'deskripsi' => 'Kebutuhan akan perubahan dan variasi dalam pekerjaan',
                'kategori' => 'Work Style'
            ],
            
            // SOCIAL NATURE (Sifat Sosial)
            [
                'kode_aspek' => 'T',
                'nama_aspek' => 'Theoretical',
                'deskripsi' => 'Orientasi pada teori dan konsep abstrak',
                'kategori' => 'Social Nature'
            ],
            [
                'kode_aspek' => 'V',
                'nama_aspek' => 'Need to be Noticed',
                'deskripsi' => 'Kebutuhan untuk diperhatikan dan diakui',
                'kategori' => 'Social Nature'
            ],
            [
                'kode_aspek' => 'S',
                'nama_aspek' => 'Social Extension',
                'deskripsi' => 'Kemampuan bersosialisasi dan menjalin hubungan',
                'kategori' => 'Social Nature'
            ],
            [
                'kode_aspek' => 'X',
                'nama_aspek' => 'Need to Belong to Groups',
                'deskripsi' => 'Kebutuhan untuk menjadi bagian dari kelompok',
                'kategori' => 'Social Nature'
            ],
            
            // WORK APPROACH (Pendekatan Kerja)
            [
                'kode_aspek' => 'L',
                'nama_aspek' => 'Logical',
                'deskripsi' => 'Pendekatan logis dan analitis dalam memecahkan masalah',
                'kategori' => 'Work Approach'
            ],
            [
                'kode_aspek' => 'P',
                'nama_aspek' => 'Practical',
                'deskripsi' => 'Pendekatan praktis dan realistis dalam bekerja',
                'kategori' => 'Work Approach'
            ],
            [
                'kode_aspek' => 'I',
                'nama_aspek' => 'Interest in Others',
                'deskripsi' => 'Ketertarikan dan perhatian terhadap orang lain',
                'kategori' => 'Work Approach'
            ],
            
            // EMOTIONAL CONTROL (Kontrol Emosi)
            [
                'kode_aspek' => 'F',
                'nama_aspek' => 'Need for Closeness and Affection',
                'deskripsi' => 'Kebutuhan akan kedekatan dan kasih sayang',
                'kategori' => 'Emotional Control'
            ],
            [
                'kode_aspek' => 'W',
                'nama_aspek' => 'Emotional Resistant',
                'deskripsi' => 'Ketahanan terhadap tekanan emosional',
                'kategori' => 'Emotional Control'
            ],
            [
                'kode_aspek' => 'K',
                'nama_aspek' => 'Aggressive',
                'deskripsi' => 'Tingkat agresivitas dan assertiveness',
                'kategori' => 'Emotional Control'
            ],
            
            // SUBORDINATION (Subordinasi)
            [
                'kode_aspek' => 'O',
                'nama_aspek' => 'Need for Support from Authority',
                'deskripsi' => 'Kebutuhan akan dukungan dan arahan dari atasan',
                'kategori' => 'Subordination'
            ],
            [
                'kode_aspek' => 'E',
                'nama_aspek' => 'Ease in Decision Making',
                'deskripsi' => 'Kemudahan dalam mengambil keputusan sendiri',
                'kategori' => 'Subordination'
            ],
        ];

        foreach ($aspekData as $data) {
            PapikostikAspek::create($data);
        }
    }
}