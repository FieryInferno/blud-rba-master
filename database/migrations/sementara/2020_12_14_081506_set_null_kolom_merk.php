<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullKolomMerk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ssh', function (Blueprint $table) {
            DB::statement('ALTER TABLE ssh MODIFY merk VARCHAR(191) NULL');
            DB::statement('ALTER TABLE ssh MODIFY spesifikasi VARCHAR(191) NULL');
            DB::statement('ALTER TABLE ssh MODIFY satuan VARCHAR(191) NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ssh', function (Blueprint $table) {
            //
        });
    }
}
