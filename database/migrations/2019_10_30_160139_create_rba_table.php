<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rba', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_rba');
            $table->string('kode_opd');
            $table->string('kode_unit_kerja');
            $table->unsignedBigInteger('pejabat_id');
            $table->enum('tipe', ['MURNI', 'PAK']);
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->string('kelompok_sasaran')->nullable();
            $table->foreign('kode_unit_kerja')->references('kode')->on('unit_kerja');
            $table->foreign('pejabat_id')->references('id')->on('pejabat_unit');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan');
            $table->string('latar_belakang');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('rba');
    }
}
