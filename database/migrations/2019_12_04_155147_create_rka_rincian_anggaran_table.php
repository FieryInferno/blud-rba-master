<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkaRincianAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_rincian_anggaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rka_id');
            $table->unsignedBigInteger('akun_id');
            $table->string('uraian')->nullable();
            $table->unsignedBigInteger('ssh_id')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('volume');
            $table->bigInteger('tarif');
            $table->bigInteger('volume_pak')->nullable();
            $table->string('satuan_pak')->nullable();
            $table->bigInteger('tarif_pak')->nullable();
            $table->bigInteger('tahun_berikutnya')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreign('rka_id')->references('id')->on('rka');
            $table->foreign('akun_id')->references('id')->on('akun');
            $table->foreign('ssh_id')->references('id')->on('ssh');
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
        Schema::dropIfExists('rka_rincian_anggaran');
    }
}
