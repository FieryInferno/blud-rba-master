<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAnggaranIdInRkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka', function (Blueprint $table) {
            $table->unsignedBigInteger('status_anggaran_id')->after('tipe')->nullable();

            $table->foreign('status_anggaran_id')->references('id')->on('status_anggaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka', function (Blueprint $table) {
            //
        });
    }
}
