<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddTimingToProgressTes extends Migration
{
    public function up()
    {
        Schema::table('progress_tes', function (Blueprint $table) {
            // Tambah kolom waktu untuk tracking durasi tes
            $table->timestamp('waktu_mulai')->nullable()->after('status');
            $table->timestamp('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->integer('durasi_tersisa')->nullable()->after('waktu_selesai')->comment('Sisa waktu dalam detik');
        });
    }

    public function down()
    {
        Schema::table('progress_tes', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai', 'durasi_tersisa']);
        });
    }
}