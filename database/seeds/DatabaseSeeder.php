<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UnitKerjaSeeder::class,
            // RolesTableSeeder::class,
            // UsersTableSeeder::class,
            // FungsiTableSeeder::class,
            // UrusanTableSeeder::class,
            // BidangTableSeeder::class,
            // JabatanTableSeeder::class,
            // KategoriAkunSeeder::class,
            // JabatanPejabatUnitTableSeeder::class,
            // AkunTableSeeder::class,
            // SumberDanaTableSeeder::class,
            // PejabatUnitTableSeeder::class,
            // ProgramTableSeeder::class,
            // KegiatanTableSeeder::class,
            PermissionsTableSeeder::class
        ]);
    }
}
