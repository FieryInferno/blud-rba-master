<?php

use Illuminate\Database\Seeder;
use App\Models\PejabatUnit;

class PejabatUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Puskemas Arjuno */
        PejabatUnit::create(['nama_pejabat' => 'dr. Umar Usman', 'nip' => '196911111999031007', 'kode_unit_kerja' => '01', 'jabatan_id' => 2]);
        PejabatUnit::create(['nama_pejabat' => 'Idha Erfiningsih,SE', 'nip' => '196604041987032014', 'kode_unit_kerja' => '01', 'jabatan_id' => 3]);
        PejabatUnit::create(['nama_pejabat' => 'Rofiutin Maulida,.Amd Farm', 'nip' => '198301072010012017', 'kode_unit_kerja' => '01', 'jabatan_id' => 4]);
        PejabatUnit::create(['nama_pejabat' => 'Verawati Nurviana,.Amd Keb', 'nip' => '198706222009032003', 'kode_unit_kerja' => '01', 'jabatan_id' => 5]);

        /** Puskemas Arjowinangun */
        PejabatUnit::create(['nama_pejabat' => 'drg. Camelia Finda Arisanti', 'nip' => '19750113 200312 2 007', 'kode_unit_kerja' => '02', 'jabatan_id' => 2]);
        PejabatUnit::create(['nama_pejabat' => 'Sodikin', 'nip' => '19690220 199003 1 009', 'kode_unit_kerja' => '02', 'jabatan_id' => 3]);
        PejabatUnit::create(['nama_pejabat' => 'Surianto', 'nip' => '19650505 198703 1 028', 'kode_unit_kerja' => '02', 'jabatan_id' => 4]);
        PejabatUnit::create(['nama_pejabat' => 'Naily Hidayah, A.Md.Kep.', 'nip' => '19830620 201101 2 003', 'kode_unit_kerja' => '02', 'jabatan_id' => 5]);
    }
}
