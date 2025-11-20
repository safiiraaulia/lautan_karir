<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dealer;
use Illuminate\Support\Facades\Schema; // <-- Tambahkan ini

class DealerSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan pengecekan Foreign Key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel
        Dealer::truncate();

        // 3. Nyalakan kembali pengecekan Foreign Key
        Schema::enableForeignKeyConstraints();

        $dealers = [
            ['kode_dealer' => '9HL001', 'nama_dealer' => 'LTI TANJUNG BINTANG', 'kota' => 'Tanjung Bintang', 'singkatan' => 'TJB'],
            ['kode_dealer' => '9HL002', 'nama_dealer' => 'LTI LIWA', 'kota' => 'Liwa', 'singkatan' => 'LWA'],
            ['kode_dealer' => '9HL002A', 'nama_dealer' => 'LTI KRUI', 'kota' => 'Krui', 'singkatan' => 'KRI'],
            ['kode_dealer' => '9HL002B', 'nama_dealer' => 'LTI SUMBER JAYA', 'kota' => 'Sumber Jaya', 'singkatan' => 'SBJ'],
            ['kode_dealer' => '9HL003', 'nama_dealer' => 'LTI KEDATON', 'kota' => 'Kedaton', 'singkatan' => 'KDT'],
            ['kode_dealer' => '9HL003B', 'nama_dealer' => 'LTI PRAMUKA', 'kota' => 'Pramuka', 'singkatan' => 'PMK'],
            ['kode_dealer' => '9HL004', 'nama_dealer' => 'LTI PURBOLINGGO', 'kota' => 'Purbolinggo', 'singkatan' => 'PBG'],
            ['kode_dealer' => '9HL004A', 'nama_dealer' => 'LTI SEKAMPUNG', 'kota' => 'Sekampung', 'singkatan' => 'SKP'],
            ['kode_dealer' => '9HL006', 'nama_dealer' => 'LTI MANDALA', 'kota' => 'Mandala', 'singkatan' => 'MDL'],
            ['kode_dealer' => '9HL007', 'nama_dealer' => 'LTI TIRTAYASA', 'kota' => 'Tirtayasa', 'singkatan' => 'TTY'],
            ['kode_dealer' => '9HL007A', 'nama_dealer' => 'LTI BINA KARYA', 'kota' => 'Bina Karya', 'singkatan' => 'BLK'],
            ['kode_dealer' => '9HL008', 'nama_dealer' => 'LTI KOTA AGUNG', 'kota' => 'Kota Agung', 'singkatan' => 'KTA'],
            ['kode_dealer' => '9HL009', 'nama_dealer' => 'LTI SIMPANG PEMATANG', 'kota' => 'Simpang Pematang', 'singkatan' => 'SPM'],
            ['kode_dealer' => 'UA22001A', 'nama_dealer' => 'LTI KEMILING', 'kota' => 'Kemiling', 'singkatan' => 'KML'],
            ['kode_dealer' => 'UA22001', 'nama_dealer' => 'LTI SENTRAL YAMAHA', 'kota' => 'Bandar Lampung', 'singkatan' => 'CTL'],
            ['kode_dealer' => 'UA22002', 'nama_dealer' => 'LTI PAHOMAN', 'kota' => 'Pahoman', 'singkatan' => 'PHM'],
            ['kode_dealer' => 'UA22003', 'nama_dealer' => 'LTI KARANG ANYAR', 'kota' => 'Karang Anyar', 'singkatan' => 'KRA'],
            ['kode_dealer' => 'UA22003A', 'nama_dealer' => 'LTI NATAR', 'kota' => 'Natar', 'singkatan' => 'NTR'],
            ['kode_dealer' => 'UB22001', 'nama_dealer' => 'LTI METRO', 'kota' => 'Metro', 'singkatan' => 'MTR'],
            ['kode_dealer' => 'UB22001A', 'nama_dealer' => 'LTI PEKALONGAN', 'kota' => 'Pekalongan', 'singkatan' => 'PKL'],
            ['kode_dealer' => 'UB22001B', 'nama_dealer' => 'LTI IMOPURO', 'kota' => 'Imopuro', 'singkatan' => 'STM'],
            ['kode_dealer' => 'UC22001', 'nama_dealer' => 'LTI KALIANDA', 'kota' => 'Kalianda', 'singkatan' => 'KLD'],
            ['kode_dealer' => 'UC22001A', 'nama_dealer' => 'LTI PATOK', 'kota' => 'Patok', 'singkatan' => 'PTK'],
            ['kode_dealer' => 'UC22002', 'nama_dealer' => 'LTI PEMATANG PASIR', 'kota' => 'Pematang Pasir', 'singkatan' => 'PPS'],
            ['kode_dealer' => 'UCUB001', 'nama_dealer' => 'LTI GEDUNG TATAAN', 'kota' => 'Gedung Tataan', 'singkatan' => 'GDT'],
            ['kode_dealer' => 'UCUB001A', 'nama_dealer' => 'LTI WIYONO', 'kota' => 'Wiyono', 'singkatan' => 'WYN'],
            ['kode_dealer' => 'UD00003', 'nama_dealer' => 'LTI RAWAJITU', 'kota' => 'Rawajitu', 'singkatan' => 'RWJ'],
            ['kode_dealer' => 'UDUA001', 'nama_dealer' => 'LTI UNIT DUA', 'kota' => 'Tulang Bawang', 'singkatan' => 'TLB'],
            ['kode_dealer' => 'UDUA001A', 'nama_dealer' => 'LTI GUNUNG TERANG', 'kota' => 'Gunung Terang', 'singkatan' => 'GNT'],
            ['kode_dealer' => 'UDUA002', 'nama_dealer' => 'LTI MENGGALA', 'kota' => 'Menggala', 'singkatan' => 'MGL'],
            ['kode_dealer' => 'UDUA002A', 'nama_dealer' => 'LTI DAYA MURNI', 'kota' => 'Daya Murni', 'singkatan' => 'DYM'],
            ['kode_dealer' => 'UDUB001A', 'nama_dealer' => 'LTI BRABASAN', 'kota' => 'Brabasan', 'singkatan' => 'BRB'],
            ['kode_dealer' => 'UDUB002', 'nama_dealer' => 'LTI BANJAR AGUNG', 'kota' => 'Banjar Agung', 'singkatan' => 'BJA'],
            ['kode_dealer' => 'UE22001', 'nama_dealer' => 'LTI BANDAR JAYA', 'kota' => 'Bandar Jaya', 'singkatan' => 'BDJ'],
            ['kode_dealer' => 'UE22002', 'nama_dealer' => 'LTI KOTA GAJAH', 'kota' => 'Kota Gajah', 'singkatan' => 'KTG'],
            ['kode_dealer' => 'UE22002A', 'nama_dealer' => 'LTI PUNGGUR', 'kota' => 'Punggur', 'singkatan' => 'PGR'],
            ['kode_dealer' => 'UE22003', 'nama_dealer' => 'LTI RUMBIA', 'kota' => 'Rumbia', 'singkatan' => 'RBA'],
            ['kode_dealer' => 'UE22003A', 'nama_dealer' => 'LTI GAYA BARU', 'kota' => 'Gaya Baru', 'singkatan' => 'GBR'],
            ['kode_dealer' => 'UFUA001', 'nama_dealer' => 'LTI KOTABUMI', 'kota' => 'Kotabumi', 'singkatan' => 'KTB'],
            ['kode_dealer' => 'UFUA001B', 'nama_dealer' => 'LTI BUNGA MAYANG', 'kota' => 'Bunga Mayang', 'singkatan' => 'BGM'],
            ['kode_dealer' => 'UFUA001C', 'nama_dealer' => 'LTI PAKUAN RATU', 'kota' => 'Pakuan Ratu', 'singkatan' => 'PKR'],
            ['kode_dealer' => 'UHUB001', 'nama_dealer' => 'LTI SRIBHAWONO', 'kota' => 'Sribhawono', 'singkatan' => 'SBW'],
            ['kode_dealer' => 'UHUB001A', 'nama_dealer' => 'LTI TRIDATU', 'kota' => 'Tridatu', 'singkatan' => 'TDT'],
            ['kode_dealer' => 'UHUE002', 'nama_dealer' => 'LTI MARGATIGA', 'kota' => 'Margatiga', 'singkatan' => 'MGT'],
            ['kode_dealer' => 'UIUB001', 'nama_dealer' => 'LTI PRINGSEWU', 'kota' => 'Pringsewu', 'singkatan' => 'PSW'],
            ['kode_dealer' => 'UIUB002', 'nama_dealer' => 'LTI KALIREJO', 'kota' => 'Kalirejo', 'singkatan' => 'KLJ'],
            ['kode_dealer' => 'UKUA001', 'nama_dealer' => 'LTI BLAMBANGAN UMPU', 'kota' => 'Blambangan Umpu', 'singkatan' => 'BMP'],
        ];

        foreach ($dealers as $dealer) {
            Dealer::create($dealer);
        }
    }
}