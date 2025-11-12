<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToPelamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelamar', function (Blueprint $table) {
            // Tambahkan kolom 'is_active', default-nya true (aktif)
            // Letakkan setelah kolom 'password'
            $table->boolean('is_active')->default(true)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelamar', function (Blueprint $table) {
            // Logika untuk 'rollback' (menghapus kolom)
            $table->dropColumn('is_active');
        });
    }
}
