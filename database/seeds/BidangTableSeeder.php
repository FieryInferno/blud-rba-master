<?php

use App\Models\Bidang;
use Illuminate\Database\Seeder;

class BidangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PELAYANAN UMUM']);
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => '1', 'kode' => '06', 'nama_bidang' => 'PERENCANAAN PEMBANGUNAN']);
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => '1', 'kode' => '20', 'nama_bidang' => 'OTONOMI DAERAH, PEMERINTAHAN UMUM, ADMINISTRASI KEUANGAN DAERAH, PERANGKAT DAERAH, KEPEGAWAIAN, DAN PERSANDIAN']);
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => '1', 'kode' => '23', 'nama_bidang' => 'STATISTIK']);
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => '1', 'kode' => '24', 'nama_bidang' => 'KEARSIPAN']);
        Bidang::create(['kode_fungsi' => '01', 'kode_urusan' => '1', 'kode' => '25', 'nama_bidang' => 'KOMUNIKASI DAN INFORMATIKA']);
        
        Bidang::create(['kode_fungsi' => '02', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PERTAHANAN']);
        
        Bidang::create(['kode_fungsi' => '03', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'KETERTIBAN DAN KETENTRAMAN']);
        Bidang::create(['kode_fungsi' => '03', 'kode_urusan' => '1', 'kode' => '19', 'nama_bidang' => 'KESATUAN BANGSA DAN POLITIK DALAM NEGERI']);
        
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'EKONOMI']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '07', 'nama_bidang' => 'PERHUBUNGAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '14', 'nama_bidang' => 'KETENAGAKERJAAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '15', 'nama_bidang' => 'KOPERASI DAN USAHA KECIL MENENGAH']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '16', 'nama_bidang' => 'PENANAMAN MODAL']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '21', 'nama_bidang' => 'KETAHANAN PANGAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '1', 'kode' => '22', 'nama_bidang' => 'PEMBERDAYAAN MASYARAKAT DAN DESA']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '01', 'nama_bidang' => 'PERTANIAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '02', 'nama_bidang' => 'KEHUTANAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '03', 'nama_bidang' => 'ENERGI DAN SUMBERDAYA MINERAL']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '05', 'nama_bidang' => 'KELAUTAN DAN PERIKANAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '06', 'nama_bidang' => 'PERDAGANGAN']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '07', 'nama_bidang' => 'INDUSTRI']);
        Bidang::create(['kode_fungsi' => '04', 'kode_urusan' => '2', 'kode' => '08', 'nama_bidang' => 'KETRANSMIGRASIAN']);
        
        Bidang::create(['kode_fungsi' => '05', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'LINGKUNGAN HIDUP']);
        Bidang::create(['kode_fungsi' => '05', 'kode_urusan' => '1', 'kode' => '05', 'nama_bidang' => 'PENATAAN RUANG']);
        Bidang::create(['kode_fungsi' => '05', 'kode_urusan' => '1', 'kode' => '08', 'nama_bidang' => 'LINGKUNGAN HIDUP']);
        Bidang::create(['kode_fungsi' => '05', 'kode_urusan' => '1', 'kode' => '09', 'nama_bidang' => 'PERTANAHAN']);
        
        Bidang::create(['kode_fungsi' => '06', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PERUMAHAN DAN FASILITAS UMUM']);
        Bidang::create(['kode_fungsi' => '06', 'kode_urusan' => '1', 'kode' => '03', 'nama_bidang' => 'PEKERJAAN UMUM']);
        Bidang::create(['kode_fungsi' => '06', 'kode_urusan' => '1', 'kode' => '04', 'nama_bidang' => 'PERUMAHAN']);
        
        Bidang::create(['kode_fungsi' => '07', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'KESEHATAN']);
        Bidang::create(['kode_fungsi' => '07', 'kode_urusan' => '1', 'kode' => '02', 'nama_bidang' => 'KESEHATAN']);
        Bidang::create(['kode_fungsi' => '07', 'kode_urusan' => '1', 'kode' => '12', 'nama_bidang' => 'KELUARGA BERENCANA DAN KELUARGA SEJAHTERA']);
        
        Bidang::create(['kode_fungsi' => '08', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PARIWISATA DAN BUDAYA']);
        Bidang::create(['kode_fungsi' => '08', 'kode_urusan' => '1', 'kode' => '17', 'nama_bidang' => 'KEBUDAYAAN']);
        Bidang::create(['kode_fungsi' => '08', 'kode_urusan' => '2', 'kode' => '04', 'nama_bidang' => 'PARIWISATA']);
        
        Bidang::create(['kode_fungsi' => '09', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'AGAMA']);
        
        Bidang::create(['kode_fungsi' => '10', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PENDIDIKAN']);
        Bidang::create(['kode_fungsi' => '10', 'kode_urusan' => '1', 'kode' => '01', 'nama_bidang' => 'PENDIDIKAN']);
        Bidang::create(['kode_fungsi' => '10', 'kode_urusan' => '1', 'kode' => '18', 'nama_bidang' => 'KEPEMUDAAN DAN OLAH RAGA']);
        Bidang::create(['kode_fungsi' => '10', 'kode_urusan' => '1', 'kode' => '26', 'nama_bidang' => 'PERPUSTAKAAN']);
        
        Bidang::create(['kode_fungsi' => '11', 'kode_urusan' => null, 'kode' => null, 'nama_bidang' => 'PERLINDUNGAN SOSIAL']);
        Bidang::create(['kode_fungsi' => '11', 'kode_urusan' => '1', 'kode' => '10', 'nama_bidang' => 'KEPENDUDUKAN DAN CATATAN SIPIL']);
        Bidang::create(['kode_fungsi' => '11', 'kode_urusan' => '1', 'kode' => '11', 'nama_bidang' => 'PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK']);
        Bidang::create(['kode_fungsi' => '11', 'kode_urusan' => '1', 'kode' => '13', 'nama_bidang' => 'SOSIAL']);
    }
}
