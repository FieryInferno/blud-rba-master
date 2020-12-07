<?php

use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['permission_name' => 'lihat RBA']);
        Permission::create(['permission_name' => 'buat RBA']);
        Permission::create(['permission_name' => 'edit RBA']);
        Permission::create(['permission_name' => 'hapus RBA']);

        Permission::create(['permission_name' => 'lihat RKA']);
        Permission::create(['permission_name' => 'buat RKA']);
        Permission::create(['permission_name' => 'edit RKA']);
        Permission::create(['permission_name' => 'hapus RKA']);
    }
}
