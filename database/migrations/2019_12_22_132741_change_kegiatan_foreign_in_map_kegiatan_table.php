<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKegiatanForeignInMapKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['kode_kegiatan_apbd']);
            $table->dropForeign(['kode_kegiatan_blud']);
            $table->dropColumn('kode_kegiatan_apbd');
            $table->dropColumn('kode_kegiatan_blud');
            $table->unsignedBigInteger('kegiatan_id_apbd')->nullable()->after('kode_unit_kerja');
            $table->unsignedBigInteger('kegiatan_id_blud')->nullable()->after('kegiatan_id_apbd');
            $table->foreign('kegiatan_id_apbd')->references('id')->on('kegiatan')->onDelete('set null');
            $table->foreign('kegiatan_id_blud')->references('id')->on('kegiatan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_kegiatan', function (Blueprint $table) {
            //
        });
    }
}
