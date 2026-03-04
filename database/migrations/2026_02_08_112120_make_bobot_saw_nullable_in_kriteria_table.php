<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBobotSawNullableInKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kriteria', function (Blueprint $table) {
            // Mengubah kolom menjadi nullable agar tidak error saat simpan kriteria master
            $table->decimal('bobot_saw', 8, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->decimal('bobot_saw', 8, 2)->nullable(false)->change();
        });
    }
}
