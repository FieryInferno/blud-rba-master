<?php

use App\Models\Fungsi;
use Illuminate\Database\Seeder;

class FungsiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['kode' => '01','nama_fungsi' => 'Pelayanan Umum', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '02','nama_fungsi' => 'Pertahanan', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '03','nama_fungsi' => 'Ketertiban dan Ketentraman', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '04','nama_fungsi' => 'Ekonomi', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '05','nama_fungsi' => 'Lingkungan Hidup', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '06','nama_fungsi' => 'Perumahan dan fasilitas umum', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '07','nama_fungsi' => 'Kesehatan', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '08','nama_fungsi' => 'Pariwisata dan Budaya', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '09','nama_fungsi' => 'Agama', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '10','nama_fungsi' => 'Pendidikan', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => '11','nama_fungsi' => 'Perlindungan Sosial', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        Fungsi::insert($data);

    }
}
