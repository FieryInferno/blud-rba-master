<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UbahForeignKeyMapKegiatanIDRba extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rba', function (Blueprint $table) {
            $table->dropForeign(['map_kegiatan_id']);
            $table->foreign('map_kegiatan_id')->references('idMapSubKegiatan')->on('mapSubKegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rba', function (Blueprint $table) {
            //
        });
    }
}
