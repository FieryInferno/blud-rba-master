<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahNamaAkunHapusRelasiAkun extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sumber_dana', function (Blueprint $table) {
            $table->dropForeign(['akun_id']);
            $table->string('namaAkun')->after('akun_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sumber_dana', function (Blueprint $table) {
            //
        });
    }
}
