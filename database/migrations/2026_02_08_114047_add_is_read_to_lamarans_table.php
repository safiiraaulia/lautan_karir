<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadToLamaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            // Menambahkan kolom is_read dengan default 0 (belum dibaca)
            $table->boolean('is_read')->default(0)->after('status');
        });
    }

    public function down()
    {
        Schema::table('lamaran', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
}
