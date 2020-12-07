<?php

use Illuminate\Database\Seeder;
use App\Models\JabatanPejabatUnit;

class JabatanPejabatUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JabatanPejabatUnit::create(['nama_jabatan' => 'Kepala SKPD']);
        JabatanPejabatUnit::create(['nama_jabatan' => 'PPK']);
        JabatanPejabatUnit::create(['nama_jabatan' => 'PPTK']);
        JabatanPejabatUnit::create(['nama_jabatan' => 'Bendahara Penerimaan']);
        JabatanPejabatUnit::create(['nama_jabatan' => 'Bendahara Pengeluaran']);
    }
}
