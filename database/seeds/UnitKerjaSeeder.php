<?php

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '01', 'nama_unit' => 'PUSKESMAS ARJUNO']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '02', 'nama_unit' => 'PUSKESMAS ARJOWINANGUN']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '03', 'nama_unit' => 'PUSKESMAS BARENG']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '04', 'nama_unit' => 'PUSKESMAS CISADEA']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '05', 'nama_unit' => 'PUSKESMAS CIPTOMULYO']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '06', 'nama_unit' => 'PUSKESMAS DINOYO']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '07', 'nama_unit' => 'PUSKESMAS GRIBIG']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '08', 'nama_unit' => 'PUSKESMAS JANTI']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '09', 'nama_unit' => 'PUSKESMAS KENDALKEREP']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '10', 'nama_unit' => 'PUSKESMAS KEDUNGKANDANG']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '11', 'nama_unit' => 'PUSKESMAS KENDALSARI']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '12', 'nama_unit' => 'PUSKESMAS MOJOLANGU']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '13', 'nama_unit' => 'PUSKESMAS MULYOREJO']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '14', 'nama_unit' => 'PUSKESMAS PANDANWANGI']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '15', 'nama_unit' => 'PUSKESMAS POLOWIJEN']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '16', 'nama_unit' => 'PUSKESMAS RAMPALCELAKET']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '17', 'nama_unit' => 'PUSKESMAS MALANG']);
        UnitKerja::create(['kode_opd' => '1.02.01', 'kode' => '18', 'nama_unit' => 'PUSKESMAS BERPANG']);
    }
}
