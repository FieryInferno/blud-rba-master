<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles              = Role::get()->pluck('id', 'role_name');

        $admin = User::create([
            'name'                  => 'Admin',
            'email'                 => 'admin@example.com',
            'username'              => 'admin',
            'password'              => Hash::make('secret'),
            'status'                => 'MURNI',
            'role_id'               => $roles['Admin'],
            'kode_unit_kerja'       => null
        ]);

        $puskesmas = User::create([
            'name'                  => 'Puskesmas',
            'email'                 => 'arjuno@example.com',
            'username'              => 'arjuno',
            'password'              => Hash::make('secret'),
            'status'                => 'MURNI',
            'role_id'               => $roles['Puskesmas'],
            'kode_unit_kerja'       => '01'
        ]);
    }
}
