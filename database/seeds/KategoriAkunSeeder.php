<?php

use App\Models\KategoriAkun;
use Illuminate\Database\Seeder;

class KategoriAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriAkun::create(['kode' => '0', 'nama_akun' => 'Perubahan Sal', 'saldo_normal' => 'Kredit']);
        KategoriAkun::create(['kode' => '1', 'nama_akun' => 'Aset', 'saldo_normal' => 'Debet']);
        KategoriAkun::create(['kode' => '2', 'nama_akun' => 'Utang', 'saldo_normal' => 'Kredit']);
        KategoriAkun::create(['kode' => '3', 'nama_akun' => 'Ekuitas', 'saldo_normal' => 'Kredit']);
        KategoriAkun::create(['kode' => '4', 'nama_akun' => 'Pendapatan - LRA', 'saldo_normal' => 'Kredit']);
        KategoriAkun::create(['kode' => '5', 'nama_akun' => 'Belanja', 'saldo_normal' => 'Debet']);
        KategoriAkun::create(['kode' => '6', 'nama_akun' => 'Transfer', 'saldo_normal' => 'Debet']);
        KategoriAkun::create(['kode' => '7', 'nama_akun' => 'Pembiayaan', 'saldo_normal' => 'Debet']);
        KategoriAkun::create(['kode' => '8', 'nama_akun' => 'Pendapatan - LO', 'saldo_normal' => 'Kredit']);
        KategoriAkun::create(['kode' => '9', 'nama_akun' => 'Beban', 'saldo_normal' => 'Debet']);
    }
}
