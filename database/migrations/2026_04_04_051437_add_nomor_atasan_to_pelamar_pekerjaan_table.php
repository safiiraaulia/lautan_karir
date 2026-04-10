<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomorAtasanToPelamarPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('pelamar_pekerjaan', function (Blueprint $table) {
            $table->string('nomor_atasan')->nullable()->after('tahun_keluar');
        });
    }

    public function down()
    {
        Schema::table('pelamar_pekerjaan', function (Blueprint $table) {
            $table->dropColumn('nomor_atasan');
        });
    }
}
