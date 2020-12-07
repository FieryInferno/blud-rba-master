<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRbaMurniIdColumnInRbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rba', function (Blueprint $table) {
            $table->unsignedBigInteger('rba_murni_id')->nullable()->after('pejabat_id');

            $table->foreign('rba_murni_id')->references('id')->on('rba');
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
            $table->dropColumn('rba_murni_id');
        });
    }
}
