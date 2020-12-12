<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatTabelSubKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subKegiatan', function (Blueprint $table) {
            $table->bigIncrements('idSubKegiatan');
            $table->string('kodeKegiatan');
            $table->string('kodeSubKegiatan');
            $table->string('namaSubKegiatan');
            $table->foreign('kodeKegiatan')->references('kode')->on('kegiatan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('subKegiatan', function (Blueprint $table) {
            //
        });
    }
}
