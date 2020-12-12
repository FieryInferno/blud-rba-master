<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelMapSubKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapSubKegiatan', function (Blueprint $table) {
            $table->bigIncrements('idMapSubKegiatan');
            $table->string('kodeUnitKerja');
            $table->string('kodeSubKegiatanBlud');
            $table->string('kodeSubKegiatanApbd');
            $table->foreign('kodeUnitKerja')->references('kode')->on('unit_kerja')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kodeSubKegiatanBlud')->references('kodeSubKegiatan')->on('subKegiatan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kodeSubKegiatanApbd')->references('kodeSubKegiatan')->on('subKegiatan')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapSubKegiatan');
    }
}
