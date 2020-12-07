<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignSshIdInRkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_rincian_anggaran', function (Blueprint $table) {
            $table->dropForeign(['ssh_id']);
            $table->foreign('ssh_id')->references('id')->on('ssh')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_rincian_anggaran', function (Blueprint $table) {
            //
        });
    }
}
