<?php

use App\Models\SumberDana;
use Illuminate\Database\Seeder;

class SumberDanaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SumberDana::create([ 'akun_id' => '6', 'nama_sumber_dana' => 'BLUD', 'nama_bank' => 'Bank Jatim', 'no_rekening' => '0041083441']);
        SumberDana::create([ 'akun_id' => '7', 'nama_sumber_dana' => 'APBD', 'nama_bank' => 'Bank Jatim', 'no_rekening' => '0041083476']);
    }
}
