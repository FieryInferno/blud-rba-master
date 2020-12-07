<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkaRincianSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_rincian_sumber_dana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rka_id');
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('sumber_dana_id');
            $table->bigInteger('nominal');
            $table->bigInteger('nominal_pak')->default(0);
            $table->foreign('rka_id')->references('id')->on('rka');
            $table->foreign('akun_id')->references('id')->on('akun');
            $table->foreign('sumber_dana_id')->references('id')->on('sumber_dana');
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
        Schema::dropIfExists('rka_rincian_sumber_dana');
    }
}
