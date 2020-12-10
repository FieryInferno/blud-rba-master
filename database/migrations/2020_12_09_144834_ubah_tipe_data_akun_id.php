<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UbahTipeDataAkunId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sumber_dana', function (Blueprint $table) {
            DB::statement("ALTER TABLE sumber_dana MODIFY akun_id VARCHAR(191)");
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
