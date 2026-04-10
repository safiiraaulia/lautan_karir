<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscPapiToLamaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->text('kesimpulan_disc')->nullable()->after('skor_akhir_saw');
            $table->text('kesimpulan_papi')->nullable()->after('kesimpulan_disc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            //
        });
    }
}
