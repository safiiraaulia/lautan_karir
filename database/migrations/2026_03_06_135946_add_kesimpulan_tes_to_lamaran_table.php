<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKesimpulanTesToLamaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->text('kesimpulan_tes')->nullable()->after('skor_akhir_saw');
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
