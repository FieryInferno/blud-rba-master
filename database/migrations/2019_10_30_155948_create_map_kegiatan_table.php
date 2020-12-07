<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_unit_kerja');
            $table->string('kode_kegiatan_blud');
            $table->string('kode_kegiatan_apbd');
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->foreign('kode_kegiatan_blud')->references('kode')->on('kegiatan');
            $table->foreign('kode_kegiatan_apbd')->references('kode')->on('kegiatan');
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
        Schema::dropIfExists('map_kegiatan');
    }
}
