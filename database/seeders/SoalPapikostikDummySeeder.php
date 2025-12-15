<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\OpsiJawaban;
use App\Models\JenisTes;
use App\Models\PapikostikScoring;
use App\Models\PapikostikAspek;

class SoalPapikostikDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Ini adalah 10 soal DUMMY untuk Tes Papikostik.
     * Struktur: Setiap soal punya 2 pernyataan (A dan B).
     * 
     * CATATAN: Ini hanya contoh struktur. Soal asli (90 soal) harus 
     * diinput setelah HRD memberikan soal lengkap dengan mapping aspeknya.
     * 
     * @return void
     */
    public function run()
    {
        $jenisTes = JenisTes::where('nama_tes', 'Papikostik')->first();        
        if (!$jenisTes) {
            $this->command->error('Jenis Tes Papikostik belum ada! Jalankan JenisTesSeeder dulu.');
            return;
        }

        // Ambil aspek untuk mapping (harus sudah ada dari PapikostikAspekSeeder)
        $aspekN = PapikostikAspek::where('kode_aspek', 'N')->first();
        $aspekG = PapikostikAspek::where('kode_aspek', 'G')->first();
        $aspekA = PapikostikAspek::where('kode_aspek', 'A')->first();
        $aspekR = PapikostikAspek::where('kode_aspek', 'R')->first();
        $aspekD = PapikostikAspek::where('kode_aspek', 'D')->first();
        $aspekC = PapikostikAspek::where('kode_aspek', 'C')->first();
        $aspekT = PapikostikAspek::where('kode_aspek', 'T')->first();
        $aspekV = PapikostikAspek::where('kode_aspek', 'V')->first();
        $aspekL = PapikostikAspek::where('kode_aspek', 'L')->first();
        $aspekS = PapikostikAspek::where('kode_aspek', 'S')->first();

        // Data soal dummy dengan mapping aspek
        $soalData = [
            [
                'pernyataan_a' => 'Saya senang menetapkan target tinggi untuk diri saya sendiri',
                'pernyataan_b' => 'Saya lebih suka memimpin daripada dipimpin',
                'aspek_a' => $aspekN,
                'aspek_b' => $aspekG,
            ],
            [
                'pernyataan_a' => 'Saya ingin orang lain mengikuti arahan saya',
                'pernyataan_b' => 'Saya bekerja dengan cepat dan efisien',
                'aspek_a' => $aspekA,
                'aspek_b' => $aspekR,
            ],
            [
                'pernyataan_a' => 'Saya sangat teratur dan disiplin dalam bekerja',
                'pernyataan_b' => 'Saya harus menyelesaikan tugas sampai tuntas',
                'aspek_a' => $aspekD,
                'aspek_b' => $aspekC,
            ],
            [
                'pernyataan_a' => 'Saya suka berpikir secara teoritis dan konseptual',
                'pernyataan_b' => 'Saya ingin diperhatikan dan diakui',
                'aspek_a' => $aspekT,
                'aspek_b' => $aspekV,
            ],
            [
                'pernyataan_a' => 'Saya berpikir secara logis dan analitis',
                'pernyataan_b' => 'Saya mudah bergaul dan bersosialisasi',
                'aspek_a' => $aspekL,
                'aspek_b' => $aspekS,
            ],
            [
                'pernyataan_a' => 'Saya lebih suka bekerja dengan target yang jelas',
                'pernyataan_b' => 'Saya senang mengambil tanggung jawab besar',
                'aspek_a' => $aspekN,
                'aspek_b' => $aspekG,
            ],
            [
                'pernyataan_a' => 'Saya suka mengatur dan mengarahkan tim',
                'pernyataan_b' => 'Saya bekerja dengan tempo yang cepat',
                'aspek_a' => $aspekA,
                'aspek_b' => $aspekR,
            ],
            [
                'pernyataan_a' => 'Saya membuat jadwal dan mengikutinya',
                'pernyataan_b' => 'Saya tidak suka meninggalkan pekerjaan setengah jadi',
                'aspek_a' => $aspekD,
                'aspek_b' => $aspekC,
            ],
            [
                'pernyataan_a' => 'Saya tertarik pada ide-ide abstrak',
                'pernyataan_b' => 'Saya ingin pendapat saya didengar',
                'aspek_a' => $aspekT,
                'aspek_b' => $aspekV,
            ],
            [
                'pernyataan_a' => 'Saya memecahkan masalah dengan analisis',
                'pernyataan_b' => 'Saya senang berada di tengah keramaian',
                'aspek_a' => $aspekL,
                'aspek_b' => $aspekS,
            ],
        ];

        foreach ($soalData as $index => $data) {
            // 1. Buat Soal
            $soal = Soal::create([
                'jenis_tes_id' => $jenisTes->id_jenis_tes,
                'isi_soal' => 'Pilih pernyataan yang PALING menggambarkan diri Anda (bisa pilih A, B, atau KEDUANYA)',
                'tipe_soal' => 'papikostik_pair' // Tipe khusus untuk Papikostik
            ]);

            // 2. Buat Opsi Jawaban A
            OpsiJawaban::create([
                'soal_id' => $soal->id_soal,
                'isi_opsi' => 'A. ' . $data['pernyataan_a']
            ]);

            // 3. Buat Opsi Jawaban B
            OpsiJawaban::create([
                'soal_id' => $soal->id_soal,
                'isi_opsi' => 'B. ' . $data['pernyataan_b']
            ]);

            // 4. Buat Scoring Rule untuk Pilihan A
            if ($data['aspek_a']) {
                PapikostikScoring::create([
                    'soal_id' => $soal->id_soal,
                    'pilihan' => 'A',
                    'aspek_id' => $data['aspek_a']->id_aspek,
                    'bobot' => 1
                ]);
            }

            // 5. Buat Scoring Rule untuk Pilihan B
            if ($data['aspek_b']) {
                PapikostikScoring::create([
                    'soal_id' => $soal->id_soal,
                    'pilihan' => 'B',
                    'aspek_id' => $data['aspek_b']->id_aspek,
                    'bobot' => 1
                ]);
            }

            $this->command->info("Soal Papikostik #" . ($index + 1) . " berhasil dibuat");
        }

        $this->command->info("✅ Total " . count($soalData) . " soal Papikostik dummy berhasil dibuat!");
    }
}