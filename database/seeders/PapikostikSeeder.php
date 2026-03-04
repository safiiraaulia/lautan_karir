<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoalKelompok;
use App\Models\OpsiJawaban;
use App\Models\JenisTes;

class PapikostikSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat/Update Jenis Tes Papikostik
        $jenisTes = JenisTes::updateOrCreate(
            ['nama_tes' => 'Papikostik'],
            ['instruksi' => 'Pada setiap nomor terdapat dua pernyataan. Pilih SATU pernyataan yang paling menggambarkan diri Anda.']
        );

        // 2. Data 90 Soal PAPI Kostick Lengkap
        $dataSoal = [
            1 => ['Saya seorang pekerja keras', 'Saya tidak suka uring-uringan'],
            2 => ['Saya suka menghasilkan pekerjaan yang lebih baik daripada orang lain', 'Saya akan tetap menangani suatu pekerjaan sampai selesai'],
            3 => ['Saya suka menunjukkan pada orang lain cara melakukan sesuatu', 'Saya ingin berusaha sebaik mungkin'],
            4 => ['Saya suka melucu', 'Saya senang memberitahu orang lain hal-hal yang harus dikerjakan'],
            5 => ['Saya suka bergabung dengan kelompok', 'Saya senang diperhatikan oleh kelompok'],
            6 => ['Saya suka menjalin hubungan pribadi yang akrab', 'Saya suka berteman dengan kelompok'],
            7 => ['Saya dapat cepat berubah jika merasa perlu', 'Saya berusaha menjalin hubungan pribadi yang akrab'],
            8 => ['Saya suka menyerang kembali jika benar-benar disakiti', 'Saya suka melakukan hal-hal yang baru dan berbeda'],
            9 => ['Saya ingin agar atasan menyukai saya', 'Saya suka menegur orang lain jika mereka melakukan kesalahan'],
            10 => ['Saya suka mengikuti petunjuk-petunjuk yang diberikan pada saya', 'Saya suka menyenangkan orang-orang yang menjadi atasan saya'],
            11 => ['Saya berusaha keras sekali', 'Saya seorang yang teratur, saya meletakkan segala sesuatu pada tempatnya'],
            12 => ['Saya dapat membuat orang lain melakukan apa yang saya inginkan', 'Saya tidak mudah marah'],
            13 => ['Saya suka memberitahu kelompok hal-hal yang harus mereka kerjakan', 'Saya selalu bertahan pada suatu pekerjaan sampai selesai'],
            14 => ['Saya ingin menjadi orang yang penuh gairah dan menarik', 'Saya ingin menjadi orang yang sangat berhasil'],
            15 => ['Saya ingin menjadi bagian dalam kelompok', 'Saya suka membantu orang lain mengambil keputusan'],
            16 => ['Saya cemas bila seseorang tidak menyukai saya', 'Saya ingin agar orang lain memperhatikan saya'],
            17 => ['Saya suka mencoba hal-hal baru', 'Saya lebih suka bekerja bersama orang lain daripada sendiri'],
            18 => ['Kadang-kadang saya menyalahkan orang lain jika ada yang tidak beres', 'Saya merasa terganggu jika seseorang tidak menyukai saya'],
            19 => ['Saya suka menyenangkan orang yang menjadi atasan saya', 'Saya senang mencoba pekerjaan yang baru dan berbeda'],
            20 => ['Saya menyukai petunjuk-petunjuk terperinci untuk melaksanakan tugas', 'Saya suka memberitahu orang lain apabila mereka menjengkelkan'],
            21 => ['Saya selalu berusaha keras', 'Saya selalu melaksanakan setiap langkah dengan sangat hati-hati'],
            22 => ['Saya seorang pemimpin yang baik', 'Saya menata pekerjaan dengan baik'],
            23 => ['Saya mudah marah', 'Saya lambat dalam membuat keputusan'],
            24 => ['Saya suka mengerjakan beberapa tugas pada saat yang bersamaan', 'Bila berada dalam satu kelompok, saya suka berdiam diri'],
            25 => ['Saya senang sekali bila diundang', 'Saya ingin melakukan sesuatu lebih baik daripada orang lain'],
            26 => ['Saya suka menjalin hubungan pribadi yang akrab', 'Saya suka memberi nasihat pada orang lain'],
            27 => ['Saya suka melakukan hal-hal yang baru dan berbeda', 'Saya suka menceritakan bagaimana saya berhasil melakukan sesuatu'],
            28 => ['Apabila pendapat saya benar, saya suka mempertahankannya', 'Saya ingin menjadi bagian dari suatu kelompok'],
            29 => ['Saya tidak mau berbeda dari orang lain', 'Saya berusaha akrab dengan orang lain'],
            30 => ['Saya senang diberitahu bagaimana melakukan suatu pekerjaan', 'Saya mudah bosan'],
            31 => ['Saya bekerja keras', 'Saya banyak berpikir dan membuat rencana'],
            32 => ['Saya memimpin kelompok', 'Detail (hal-hal kecil) menarik bagi saya'],
            33 => ['Saya membuat keputusan dengan mudah dan cepat', 'Saya menyimpan barang-barang secara rapi dan teratur'],
            34 => ['Saya membuat keputusan dengan mudah dan cepat', 'Saya jarang marah atau sedih'],
            35 => ['Saya ingin menjadi bagian dalam kelompok', 'Saya ingin melakukan hanya satu pekerjaan pada satu waktu'],
            36 => ['Saya berusaha berteman secara akrab', 'Saya berusaha sangat keras untuk menjadi yang terbaik'],
            37 => ['Saya suka gaya terbaru dalam hal pakaian dan mobil', 'Saya suka bertanggung jawab atas orang lain'],
            38 => ['Saya senang berdebat', 'Saya suka mendapat perhatian'],
            39 => ['Saya suka menyenangkan orang yang menjadi atasan saya', 'Saya tertarik untuk menjadi bagian dari kelompok'],
            40 => ['Saya suka mengikuti peraturan dengan hati-hati', 'Saya suka orang lain mengenal saya dengan baik'],
            41 => ['Saya berusaha keras sekali', 'Saya sangat ramah'],
            42 => ['Orang lain berpendapat bahwa saya pemimpin yang baik', 'Saya berpikir hati-hati dan lama'],
            43 => ['Saya sering memanfaatkan kesempatan', 'Saya suka cerewet mengenai hal-hal yang kecil'],
            44 => ['Orang lain berpendapat bahwa saya bekerja cepat', 'Orang lain berpendapat bahwa saya menyimpan segala sesuatu secara teratur dan rapi'],
            45 => ['Saya menyukai permainan dan olahraga', 'Saya sangat menyenangkan'],
            46 => ['Saya senang bila orang lain bersikap akrab dan ramah', 'Saya selalu berusaha menyelesaikan sesuatu yang telah saya mulai'],
            47 => ['Saya suka bereksperimen dan mencoba hal-hal baru', 'Saya suka melaksanakan pekerjaan sulit dengan baik'],
            48 => ['Saya suka diperlakukan secara adil', 'Saya suka memberitahu orang lain cara mengerjakan sesuatu'],
            49 => ['Saya suka melakukan hal-hal yang diharapkan dari saya', 'Saya suka mendapat perhatian'],
            50 => ['Saya suka petunjuk-petunjuk terperinci untuk melaksanakan suatu tugas', 'Saya senang berada bersama orang lain'],
            51 => ['Saya selalu berusaha melakukan pekerjaan secara sempurna', 'Orang mengatakan bahwa saya hampir tidak pernah lelah'],
            52 => ['Saya tipe seorang pemimpin', 'Saya mudah berteman'],
            53 => ['Saya memanfaatkan kesempatan', 'Saya banyak sekali berpikir'],
            54 => ['Saya bekerja dengan tempo yang cepat dan mantap', 'Saya senang menangani pekerjaan detail'],
            55 => ['Saya memiliki banyak tenaga untuk permainan dan olahraga', 'Saya menyimpan segala sesuatu secara rapi dan teratur'],
            56 => ['Saya bergaul dengan semua orang', 'Saya berwatak tenang'],
            57 => ['Saya ingin bertemu orang-orang baru dan melakukan hal-hal baru', 'Saya selalu ingin menyelesaikan pekerjaan yang telah saya mulai'],
            58 => ['Saya biasanya suka mempertahankan keyakinan saya', 'Saya biasanya suka bekerja keras'],
            59 => ['Saya menyukai saran-saran dan orang-orang yang saya kagumi', 'Saya suka bertanggung jawab terhadap orang lain'],
            60 => ['Saya membiarkan orang lain mempengaruhi diri saya secara kuat', 'Saya suka mendapat banyak perhatian'],
            61 => ['Saya biasanya bekerja keras sekali', 'Saya biasanya bekerja cepat'],
            62 => ['Apabila saya berbicara, kelompok menyimak', 'Saya terampil menggunakan peralatan'],
            63 => ['Saya lambat dalam berteman', 'Saya lambat dalam mengambil keputusan'],
            64 => ['Saya biasanya makan dengan cepat', 'Saya senang membaca'],
            65 => ['Saya menyukai pekerjaan yang membuat saya banyak bergerak', 'Saya menyukai pekerjaan yang harus saya kerjakan secara hati-hati'],
            66 => ['Saya berteman dengan sebanyak mungkin orang', 'Saya dapat menemukan sesuatu yang telah saya sisihkan'],
            67 => ['Saya merencana jauh di muka', 'Saya selalu menyenangkan'],
            68 => ['Saya sangat bangga akan nama baik saya', 'Saya tetap menangani suatu permasalahan sampai terpecahkan'],
            69 => ['Saya suka menyenangkan orang-orang yang saya kagumi', 'Saya ingin berhasil'],
            70 => ['Saya suka orang lain membuat keputusan-keputusan untuk kelompok', 'Saya suka membuat keputusan-keputusan untuk kelompok'],
            71 => ['Saya selalu berusaha sangat keras', 'Saya membuat keputusan secara mudah dan cepat'],
            72 => ['Kelompok biasanya melaksanakan keinginan saya', 'Saya biasa tergesa-gesa'],
            73 => ['Saya sering merasa lelah', 'Saya lambat dalam membuat keputusan'],
            74 => ['Saya bekerja cepat', 'Saya mudah berteman'],
            75 => ['Saya biasanya bersemangat atau bergairah', 'Saya menggunakan banyak waktu untuk berpikir'],
            76 => ['Saya sangat ramah terhadap orang lain', 'Saya menyukai pekerjaan yang menuntut ketelitian'],
            77 => ['Saya banyak berpikir dan merencana', 'Saya menyimpan segala sesuatu pada tempatnya'],
            78 => ['Saya menyukai pekerjaan yang menuntut hal-hal yang mendetail', 'Saya tidak cepat marah'],
            79 => ['Saya suka mengikuti orang-orang yang saya kagumi', 'Saya selalu menyelesaikan pekerjaan yang telah saya mulai'],
            80 => ['Saya menyukai petunjuk-petunjuk yang jelas', 'Saya suka bekerja keras'],
            81 => ['Saya mengejar hal-hal yang menjadi keinginan saya', 'Saya seorang pemimpin yang baik'],
            82 => ['Saya membuat orang lain bekerja keras', 'Saya suka bersenang-senang'],
            83 => ['Saya membuat keputusan dengan cepat', 'Saya berbicara cepat'],
            84 => ['Saya biasanya bekerja secara tergesa-gesa', 'Saya berolahraga secara teratur'],
            85 => ['Saya tidak suka bertemu orang-orang lain', 'Saya cepat lelah'],
            86 => ['Saya berteman dengan banyak sekali orang', 'Saya menggunakan banyak waktu untuk berpikir'],
            87 => ['Saya suka bekerja dengan teori', 'Saya suka melaksanakan pekerjaan detail'],
            88 => ['Saya suka melaksanakan pekerjaan detail', 'Saya suka mengatur pekerjaan saya'],
            89 => ['Saya meletakkan segala sesuatu pada tempatnya', 'Saya selalu menyenangkan'],
            90 => ['Saya senang diberitahu hal-hal yang harus saya kerjakan', 'Saya harus menyelesaikan apa yang telah saya mulai'],
        ];

        foreach ($dataSoal as $no => $pernyataans) {
            // Membuat wadah kelompok soal
            $kelompok = SoalKelompok::create([
                'jenis_tes_id' => $jenisTes->id_jenis_tes,
                'nomor_kelompok' => $no,
                'tipe_soal' => 'papikostik',
            ]);

            $labels = ['A', 'B'];
            foreach ($pernyataans as $index => $teks) {
                OpsiJawaban::create([
                    'soal_id' => $kelompok->id_soal_kelompok,
                    'isi_opsi' => $teks,
                    'kode_aspek' => $labels[$index], // A atau B
                ]);
            }
        }
    }
}