<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKeyKegiatanIdInRkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka', function (Blueprint $table) {
            $table->dropForeign(['kode_kegiatan']);
            $table->dropColumn('kode_kegiatan');
            $table->unsignedBigInteger('map_kegiatan_id')->after('tipe')->nullable();
            $table->foreign('map_kegiatan_id')->references('id')->on('map_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka', function (Blueprint $table) {
            //
        });
    }
}
