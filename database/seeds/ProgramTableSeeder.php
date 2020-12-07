<?php

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::create(['kode' => '01', 'kode_bidang' => '02', 'nama_program' => 'Program UKM Esensial']);
        Program::create(['kode' => '02', 'kode_bidang' => '02', 'nama_program' => 'PROGRAM UKM PENGEMBANGAN']);
        Program::create(['kode' => '03', 'kode_bidang' => '02', 'nama_program' => 'PROGRAM UKP']);
        Program::create(['kode' => '04', 'kode_bidang' => '02', 'nama_program' => 'PROGRAM JARINGAN DAN JEJARING FASYANKES']);
        Program::create(['kode' => '05', 'kode_bidang' => '02', 'nama_program' => 'PROGRAM ADMINISTRASI DAN MANAJEMEN PUSKESMAS']);
        Program::create(['kode' => '06', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Pengembangan Sistem Pelaporan Capaian Kinerja dan Keuangan']);
        Program::create(['kode' => '07', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Kuantitas dan Kualitas Pelayanan Publik']);
        Program::create(['kode' => '08', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Kapasitas Kinerja Lembaga dan Aparatur Pemerintah']);
        Program::create(['kode' => '15', 'kode_bidang' => '02', 'nama_program' => 'Program Obat dan Perbekalan Kesehatan']);
        Program::create(['kode' => '16', 'kode_bidang' => '02', 'nama_program' => 'Program Upaya Kesehatan Masyarakat']);
        Program::create(['kode' => '19', 'kode_bidang' => '02', 'nama_program' => 'Program Promosi Kesehatan dan Pemberdayaan Masyarakat']);
        Program::create(['kode' => '21', 'kode_bidang' => '02', 'nama_program' => 'Program Pengembangan Lingkungan Sehat']);
        Program::create(['kode' => '23', 'kode_bidang' => '02', 'nama_program' => 'Program Standarisasi Pelayanan Kesehatan']);
        Program::create(['kode' => '26', 'kode_bidang' => '02', 'nama_program' => 'Program Pengadaan, Peningkatan Sarana dan Prasarana Rumah Sakit/Rumah Sakit Jiwa/Rumah Sakit Paru-Paru/Rumah Sakit Mata']);
        Program::create(['kode' => '27', 'kode_bidang' => '02', 'nama_program' => 'Program Pemeliharaan Sarana dan Prasarana Rumah Sakit/Rumah Sakit Jiwa/Rumah Sakit Paru-Paru/Rumah Sakit Mata']);
        Program::create(['kode' => '28', 'kode_bidang' => '02', 'nama_program' => 'Program Kemitraan Peningkatan Pelayanan Kesehatan']);
        Program::create(['kode' => '33', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Pelayanan Kesehatan']);
        Program::create(['kode' => '34', 'kode_bidang' => '02', 'nama_program' => 'Program Pemenuhan Pelayanan Dasar dan Jaminan Sosial']);
        Program::create(['kode' => '36', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Mutu Pelayanan']);
        Program::create(['kode' => '42', 'kode_bidang' => '02', 'nama_program' => 'Program Peningkatan Mutu Pelayanan Kesehatan BLUD']);
        Program::create(['kode' => '43', 'kode_bidang' => '02', 'nama_program' => 'Operasional Puskesmas']);
    }
}
