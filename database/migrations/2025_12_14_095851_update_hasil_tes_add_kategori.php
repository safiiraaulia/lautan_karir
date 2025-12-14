<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHasilTesAddKategori extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan kolom untuk kesimpulan otomatis hasil tes:
     * - kategori_hasil: Kesimpulan umum (Sangat Direkomendasikan, Direkomendasikan, dll)
     * - rekomendasi: Saran untuk HRD
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            // Kategori hasil tes (auto-generated berdasarkan skor)
            $table->string('kategori_hasil')->nullable()->after('detail_nilai');
            // Nilai: 'Sangat Direkomendasikan', 'Direkomendasikan', 'Cukup', 'Tidak Direkomendasikan'
            
            // Rekomendasi untuk HRD (auto-generated)
            $table->text('rekomendasi')->nullable()->after('kategori_hasil');
            
            // Skor total (opsional, untuk sorting/filtering)
            $table->decimal('skor_total', 8, 2)->nullable()->after('rekomendasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hasil_tes', function (Blueprint $table) {
            $table->dropColumn(['kategori_hasil', 'rekomendasi', 'skor_total']);
        });
    }
}