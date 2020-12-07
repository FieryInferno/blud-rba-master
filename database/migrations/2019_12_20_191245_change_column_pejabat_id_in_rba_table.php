<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnPejabatIdInRbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rba', function (Blueprint $table) {
            $table->dropForeign(['pejabat_id']);
            DB::statement("ALTER TABLE rba MODIFY pejabat_id BIGINT UNSIGNED NULL");
            $table->foreign('pejabat_id')->references('id')->on('pejabat_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rba', function (Blueprint $table) {
            //
        });
    }
}
