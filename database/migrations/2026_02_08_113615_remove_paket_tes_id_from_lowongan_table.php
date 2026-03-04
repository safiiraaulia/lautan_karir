<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePaketTesIdFromLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lowongan', function (Blueprint $table) {
            // Kita hapus foreign key dan kolomnya
            $table->dropForeign(['paket_tes_id']); // Hapus relasinya dulu
            $table->dropColumn('paket_tes_id');     // Baru hapus kolomnya
        });
    }

    public function down()
    {
        Schema::table('lowongan', function (Blueprint $table) {
            $table->unsignedBigInteger('paket_tes_id')->after('dealer_id');
        });
    }
}
