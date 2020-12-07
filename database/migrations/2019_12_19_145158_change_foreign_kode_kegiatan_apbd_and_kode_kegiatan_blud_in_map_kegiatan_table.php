<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKodeKegiatanApbdAndKodeKegiatanBludInMapKegiatanTable extends Migration
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
            DB::statement("ALTER TABLE map_kegiatan MODIFY kode_kegiatan_apbd VARCHAR(191) NULL");
            DB::statement("ALTER TABLE map_kegiatan MODIFY kode_kegiatan_blud VARCHAR(191) NULL");
            $table->foreign('kode_kegiatan_apbd')->references('kode')->on('kegiatan')->onDelete('set null');
            $table->foreign('kode_kegiatan_blud')->references('kode')->on('kegiatan')->onDelete('set null');
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
