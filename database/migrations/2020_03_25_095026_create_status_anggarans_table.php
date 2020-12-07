<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_anggaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status_anggaran');
            $table->boolean('is_copyable')->default(true);
            $table->enum('status_perubahan', ['MURNI', 'PERUBAHAN']);
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
        Schema::dropIfExists('status_anggaran');
    }
}
