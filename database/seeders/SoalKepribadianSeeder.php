<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoalKelompok;
use App\Models\OpsiJawaban;
use App\Models\JenisTes;

class SoalKepribadianSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat/Update Jenis Tes 'Kepribadian'
        $jenisTes = JenisTes::updateOrCreate(
            ['nama_tes' => 'Kepribadian'],
            [
                'instruksi' => 'Pilihlah satu (1) pernyataan yang Paling Menggambarkan diri Anda (M) dan satu (1) yang Paling Tidak Menggambarkan diri Anda (L).'
            ]
        );

        // 2. Data 24 Kelompok DISC (Pernyataan 1=D, 2=I, 3=S, 4=C)
        $dataSoal = [
            1 => ['Bersemangat', 'Mudah menyetujui / penurut', 'Berkeinginan kuat / sangat berminat', 'Bersedia membantu orang lain'],
            2 => ['Percaya kepada kemampuan sendiri', 'Prihatin terhadap sesama', 'Penuh pengertian terhadap sesama', 'Berani mempertahankan'],
            3 => ['Suka menyenangkan orang lain', 'Bekerja dengan tepat dan cermat', 'Memiliki keberanian', 'Tidak mudah kecewa'],
            4 => ['Menyukai tantangan', 'Penuh pemikiran / perhatian', 'Menyenangkan hati / riang gembira', 'Mudah bergaul'],
            5 => ['Menunjukkan rasa hormat', 'Suka mengambil kesempatan', 'Selalu berpikir positif', 'Mengerjakan sesuatu untuk sesama'],
            6 => ['Suka berdebat', 'Mengerjakan sesuatu sesuai perintah', 'Tidak terlalu serius', 'Berwatak gembira'],
            7 => ['Suka berkawan / berteman', 'Ingin segala sesuatu berjalan dengan benar', 'Menyatakan apa yang dipikirkan', 'Berhati-hati untuk tidak terlibat'],
            8 => ['Percaya pada orang lain', 'Puas terhadap diri sendiri', 'Bersikap baik pada orang lain', 'Tidak suka bersilang pendapat / berdebat'],
            9 => ['Pandai bergaul', 'Bertingkah laku baik / bersikap sewajarnya', 'Penuh semangat', 'Tidak mudah cemas akan segala sesuatu'],
            10 => ['Mengikuti gagasan orang lain', 'Berani', 'Dapat diandalkan', 'Ramah dan menyenangkan'],
            11 => ['Mau menerima gagasan baru', 'Berusaha menyenangkan orang lain', 'Pantang menyerah', 'Periang'],
            12 => ['Suka bergaul dan bersahabat', 'Dapat menunggu dengan sabar', 'Tergantung pada diri sendiri / mandiri', 'Berbicara dengan lembut'],
            13 => ['Mau mengambil risiko', 'Mudah menerima saran', 'Baik dan tulus hati', 'Tenang'],
            14 => ['Mudah merasa bosan', 'Senang membantu teman', 'Ingin disukai', 'Berusaha mengerjakan apa yang diperintahkan'],
            15 => ['Ingin segalanya tepat dan akurat', 'Patuh pada perintah', 'Ingin selalu menang', 'Suka bergurau'],
            16 => ['Berani terlibat', 'Menyemangati orang lain', 'Bersedia mengalah', 'Tidak berani'],
            17 => ['Patuh pada peraturan', 'Bersedia berbagi dengan orang lain', 'Ceria', 'Menyelesaikan tugas'],
            18 => ['Menunjukkan penghargaan', 'Baik hati', 'Pasrah', 'Bertekad mencapai hasil'],
            19 => ['Lemah lembut', 'Dapat mempengaruhi orang lain untuk setuju', 'Rendah hati', 'Mengerjakan sesuatu secara berbeda'],
            20 => ['Ramah kepada orang lain', 'Mau bekerja sama', 'Suka pada gagasan sendiri', 'Baik hati'],
            21 => ['Menghindari kesulitan', 'Siaga / siap berbuat sesuatu', 'Dapat meyakinkan orang lain terhadap pandangannya', 'Berkemauan keras / bersungguh-sungguh'],
            22 => ['Memaksa diri untuk berbuat sesuatu', 'Periang', 'Mudah memanfaatkan peluang', 'Takut mengambil kesempatan'],
            23 => ['Suka berbicara', 'Pengendalian diri', 'Bekerja sesuai dengan kebiasaan', 'Suka mengambil keputusan'],
            24 => ['Bertata krama / sopan santun', 'Pemberani', 'Hati-hati agar tidak menyakiti orang lain', 'Merasa puas'],
        ];

        $aspekMapping = ['D', 'I', 'S', 'C'];

        foreach ($dataSoal as $no => $pernyataans) {
            $kelompok = SoalKelompok::create([
                'jenis_tes_id' => $jenisTes->id_jenis_tes,
                'nomor_kelompok' => $no,
            ]);

            foreach ($pernyataans as $index => $teks) {
                OpsiJawaban::create([
                    'soal_id' => $kelompok->id_soal_kelompok,
                    'isi_opsi' => $teks,
                    'kode_aspek' => $aspekMapping[$index], 
                ]);
            }
        }
    }
}