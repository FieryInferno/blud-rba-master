<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTarifInRkaRincianAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_rincian_anggaran', function (Blueprint $table) {
            DB::statement("ALTER TABLE rka_rincian_anggaran MODIFY tarif DECIMAL(13,2), MODIFY tarif_pak DECIMAL(13,2)");
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
