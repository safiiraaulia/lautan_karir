<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jawaban_tes', function (Blueprint $table) {
            // 1. Hapus foreign key lama yang salah arah (mencari 'pelamars.id')
            $table->dropForeign(['pelamar_id']);

            // 2. Buat foreign key baru yang mengarah ke tabel & kolom yang benar
            $table->foreign('pelamar_id')
                  ->references('id_pelamar') // Nama Primary Key di tabel pelamar
                  ->on('pelamar')           // Nama Tabel pelamar kamu
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jawaban_tes', function (Blueprint $table) {
            $table->dropForeign(['pelamar_id']);
            $table->foreignId('pelamar_id')->constrained();
        });
    }
};