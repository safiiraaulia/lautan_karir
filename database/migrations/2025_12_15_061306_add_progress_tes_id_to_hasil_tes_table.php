<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgressTesIdToHasilTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('hasil_tes', function (Blueprint $table) {
        //     $table->unsignedBigInteger('progress_tes_id')->nullable()->after('jenis_tes_id');

        //     $table->foreign('progress_tes_id')
        //         ->references('id_progress_tes')
        //         ->on('progress_tes')
        //         ->onDelete('cascade');
        // });
    }

    public function down()
    {
        // Schema::table('hasil_tes', function (Blueprint $table) {
        //     $table->dropForeign(['progress_tes_id']);
        //     $table->dropColumn('progress_tes_id');
        // });
    }

}
