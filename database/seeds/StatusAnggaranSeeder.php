<?php

use App\Models\StatusAnggaran;
use Illuminate\Database\Seeder;

class StatusAnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusAnggaran::create(['status_anggaran' => 'MURNI', 'is_copyable' => true, 'status_perubahan' => 'MURNI']);
        StatusAnggaran::create(['status_anggaran' => 'PERUBAHAN 1', 'is_copyable' => true, 'status_perubahan' => 'PERUBAHAN']);
        StatusAnggaran::create(['status_anggaran' => 'PAK', 'is_copyable' => false, 'status_perubahan' => 'PERUBAHAN']);
    }
}
