<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkaIndikatorKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_indikator_kerja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rka_id');
            $table->string('jenis_indikator');
            $table->string('tolak_ukur_kerja');
            $table->string('target_kerja');
            $table->string('jenis_indikator_pak')->nullable();
            $table->string('tolak_ukur_kerja_pak')->nullable();
            $table->string('target_kerja_pak')->nullable();
            $table->foreign('rka_id')->references('id')->on('rka');
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
        Schema::dropIfExists('rka_indikator_kerja');
    }
}
