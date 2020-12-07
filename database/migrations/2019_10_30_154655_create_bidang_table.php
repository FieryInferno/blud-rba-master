<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode')->index()->nullable();
            $table->string('kode_fungsi');
            $table->string('kode_urusan')->nullable();
            $table->string('nama_bidang')->nullable();
            $table->foreign('kode_fungsi')->references('kode')->on('fungsi');
            $table->foreign('kode_urusan')->references('kode')->on('urusan');
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
        Schema::dropIfExists('bidang');
    }
}
