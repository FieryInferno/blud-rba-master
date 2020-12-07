<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapAkunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_akun', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_akun');
            $table->string('kode_map_akun')->nullable();
            $table->foreign('kode_akun')->references('kode_akun')->on('akun');
            $table->foreign('kode_map_akun')->references('kode_akun')->on('akun');
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
        Schema::dropIfExists('map_akun');
    }
}
