<?php

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::create(['nama_jabatan' => 'Kepala Daerah']);
        Jabatan::create(['nama_jabatan' => 'Wakil Kepala Daerah']);
        Jabatan::create(['nama_jabatan' => 'Ketua Daerah']);
        Jabatan::create(['nama_jabatan' => 'Wakil Ketua Daerah']);
        Jabatan::create(['nama_jabatan' => 'Kepala BAPPEDA']);
        Jabatan::create(['nama_jabatan' => 'Kepala BAWASDA']);
        Jabatan::create(['nama_jabatan' => 'PPK']);
        Jabatan::create(['nama_jabatan' => 'PPKom']);
        Jabatan::create(['nama_jabatan' => 'Sekretaris Daerah']);
        Jabatan::create(['nama_jabatan' => 'Sekretaris DPRD']);
        Jabatan::create(['nama_jabatan' => 'Asisten Daerah I']);
        Jabatan::create(['nama_jabatan' => 'Asisten Daerah II']);
        Jabatan::create(['nama_jabatan' => 'Asisten Daerah III']);
        Jabatan::create(['nama_jabatan' => 'Asisten Daerah IV']);
        Jabatan::create(['nama_jabatan' => 'BUD / Kuasa BUD']);
        Jabatan::create(['nama_jabatan' => 'PPKD']);
    }
}
