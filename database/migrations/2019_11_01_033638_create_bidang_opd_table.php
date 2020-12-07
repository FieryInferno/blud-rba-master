<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidangOpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidang_opd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('opd_id');
            $table->string('kode_bidang');
            $table->foreign('kode_bidang')->references('kode')->on('bidang');
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
        Schema::dropIfExists('bidang_opd');
    }
}
