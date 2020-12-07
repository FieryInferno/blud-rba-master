<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipe');
            $table->string('kelompok')->nullable();
            $table->string('jenis')->nullable();
            $table->string('objek')->nullable();
            $table->string('rincian')->nullable();
            $table->string('sub1')->nullable();
            $table->string('sub2')->nullable();
            $table->string('sub3')->nullable();
            $table->string('kode_akun')->index();
            $table->string('nama_akun');
            $table->unsignedBigInteger('kategori_id');
            $table->string('pagu')->nullable()->default('0');
            $table->foreign('kategori_id')->references('id')->on('kategori_akun');
            $table->boolean('is_parent')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('akun');
    }
}
