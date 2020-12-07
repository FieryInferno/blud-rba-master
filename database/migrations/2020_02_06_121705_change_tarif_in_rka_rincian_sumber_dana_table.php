<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTarifInRkaRincianSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_rincian_sumber_dana', function (Blueprint $table) {
            DB::statement("ALTER TABLE rka_rincian_sumber_dana MODIFY nominal DECIMAL(13,2), MODIFY nominal_pak DECIMAL(13,2)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_rincian_sumber_dana', function (Blueprint $table) {
            //
        });
    }
}
