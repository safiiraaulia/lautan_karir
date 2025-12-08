<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_tes', function (Blueprint $table) {
            $table->id('id_hasil_tes'); // Primary Key
            
            // Foreign Keys (penghubung)
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('jenis_tes_id');
            
            // KOLOM SAKTI (JSON):
            // Bisa menyimpan nilai tunggal seperti {"score": 80}
            // Atau nilai kompleks Papikostik seperti {"G": 4, "L": 5, "I": 2, "T": 6}
            // Tanpa perlu ubah database lagi.
            $table->json('detail_nilai')->nullable(); 
            
            // Kesimpulan teks singkat (misal: "Disarankan", "Tidak Disarankan")
            $table->string('kesimpulan')->nullable(); 
            
            $table->timestamps();

            // Aturan Relasi (Agar data konsisten)
            $table->foreign('lamaran_id')
                  ->references('id_lamaran')->on('lamaran') // Sesuai tabel lamaran Anda
                  ->onDelete('cascade');
                  
            $table->foreign('jenis_tes_id')
                  ->references('id_jenis_tes')->on('jenis_tes') // Sesuai tabel jenis_tes Anda
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_tes');
    }
}