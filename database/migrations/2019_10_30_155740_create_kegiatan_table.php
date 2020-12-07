<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode')->nullable()->index();
            $table->string('kode_bidang');
            $table->string('kode_program');
            $table->string('nama_kegiatan');
            $table->foreign('kode_bidang')->references('kode')->on('bidang');
            $table->foreign('kode_program')->references('kode')->on('program');
            $table->boolean('is_parent')->default(0);
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
        Schema::dropIfExists('kegiatan');
    }
}
