<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRkaMurniIdColumnInRkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka', function (Blueprint $table) {
            $table->unsignedBigInteger('rka_murni_id')->nullable()->after('pejabat_id');

            $table->foreign('rka_murni_id')->references('id')->on('rka');
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
            $table->dropColumn('rka_murni_id');
        });
    }
}
