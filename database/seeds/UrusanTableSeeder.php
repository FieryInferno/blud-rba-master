<?php

use App\Models\Urusan;
use Illuminate\Database\Seeder;

class UrusanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['kode' => '1', 'nama_urusan' => 'Urusan Wajib', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '2', 'nama_urusan' => 'Urusan Pilihan', 'created_at' => now(), 'updated_at' => now()]
        ];
        Urusan::insert($data);
    }
}
