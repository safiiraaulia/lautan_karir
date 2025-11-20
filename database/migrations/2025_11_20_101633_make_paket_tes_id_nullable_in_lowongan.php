<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakePaketTesIdNullableInLowongan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah kolom paket_tes_id menjadi NULLABLE (Boleh Kosong)
        DB::statement('ALTER TABLE lowongan MODIFY paket_tes_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Mengembalikan kolom menjadi NOT NULL (Wajib Isi)
        // Hati-hati: Ini akan error jika ada data yang null saat di-rollback
        DB::statement('ALTER TABLE lowongan MODIFY paket_tes_id BIGINT UNSIGNED NOT NULL');
    }
}