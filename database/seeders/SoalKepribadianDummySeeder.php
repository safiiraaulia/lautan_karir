<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\JenisTes;
use App\Models\KepribadianScoring;
use App\Models\KepribadianDimensi;

class SoalKepribadianDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Ini adalah 10 soal DUMMY untuk Tes Kepribadian (Big Five).
     * Format: Skala Likert 1-5 (Sangat Tidak Setuju hingga Sangat Setuju).
     * 
     * CATATAN: Ini hanya contoh. Soal asli harus diinput setelah 
     * HRD memberikan instrumen lengkap.
     * 
     * @return void
     */
    public function run()
    {
        $jenisTes = JenisTes::where('nama_tes', 'Kepribadian')->first();
        
        if (!$jenisTes) {
            $this->command->error('Jenis Tes Kepribadian belum ada! Jalankan JenisTesSeeder dulu.');
            return;
        }

        // Ambil dimensi Big Five
        $dimensiO = KepribadianDimensi::where('kode_dimensi', 'O')->first(); // Openness
        $dimensiC = KepribadianDimensi::where('kode_dimensi', 'C')->first(); // Conscientiousness
        $dimensiE = KepribadianDimensi::where('kode_dimensi', 'E')->first(); // Extraversion
        $dimensiA = KepribadianDimensi::where('kode_dimensi', 'A')->first(); // Agreeableness
        $dimensiN = KepribadianDimensi::where('kode_dimensi', 'N')->first(); // Neuroticism

        // Data soal dengan mapping dimensi
        // is_reverse = true artinya soal dibalik (untuk cek konsistensi)
        $soalData = [
            [
                'pernyataan' => 'Saya senang mencoba hal-hal baru dan berbeda',
                'dimensi' => $dimensiO,
                'is_reverse' => false
            ],
            [
                'pernyataan' => 'Saya selalu menyelesaikan pekerjaan tepat waktu',
                'dimensi' => $dimensiC,
                'is_reverse' => false
            ],
            [
                'pernyataan' => 'Saya merasa nyaman berbicara di depan banyak orang',
                'dimensi' => $dimensiE,
                'is_reverse' => false
            ],
            [
                'pernyataan' => 'Saya mudah memaafkan kesalahan orang lain',
                'dimensi' => $dimensiA,
                'is_reverse' => false
            ],
            [
                'pernyataan' => 'Saya sering merasa cemas tanpa alasan jelas',
                'dimensi' => $dimensiN,
                'is_reverse' => false
            ],
            [
                'pernyataan' => 'Saya lebih suka rutinitas yang sudah familiar',
                'dimensi' => $dimensiO,
                'is_reverse' => true // Reverse: skor rendah = Openness tinggi
            ],
            [
                'pernyataan' => 'Saya kadang menunda-nunda pekerjaan',
                'dimensi' => $dimensiC,
                'is_reverse' => true // Reverse: skor rendah = Conscientiousness tinggi
            ],
            [
                'pernyataan' => 'Saya lebih suka bekerja sendiri daripada dalam tim',
                'dimensi' => $dimensiE,
                'is_reverse' => true // Reverse
            ],
            [
                'pernyataan' => 'Saya mudah tersinggung oleh kritikan',
                'dimensi' => $dimensiA,
                'is_reverse' => true // Reverse
            ],
            [
                'pernyataan' => 'Saya tetap tenang dalam situasi sulit',
                'dimensi' => $dimensiN,
                'is_reverse' => true // Reverse: skor tinggi = Neuroticism rendah
            ],
        ];

        foreach ($soalData as $index => $data) {
            // 1. Buat Soal (untuk Likert, tidak perlu opsi_jawaban karena selalu 1-5)
            $soal = Soal::create([
                'jenis_tes_id' => $jenisTes->id_jenis_tes,
                'isi_soal' => $data['pernyataan'],
                'tipe_soal' => 'likert_scale' // Tipe khusus untuk skala Likert
            ]);

            // 2. Buat Scoring Rule
            if ($data['dimensi']) {
                KepribadianScoring::create([
                    'soal_id' => $soal->id_soal,
                    'dimensi_id' => $data['dimensi']->id_dimensi,
                    'is_reverse' => $data['is_reverse'],
                    'bobot' => 1
                ]);
            }

            $reverseLabel = $data['is_reverse'] ? ' [REVERSE]' : '';
            $this->command->info("Soal Kepribadian #" . ($index + 1) . $reverseLabel . " berhasil dibuat");
        }

        $this->command->info("✅ Total " . count($soalData) . " soal Kepribadian dummy berhasil dibuat!");
    }
}