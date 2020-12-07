<?php

namespace App\Http\Controllers\Api;

use App\Models\Rba;
use App\Models\Ssh;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\RBA\RBA221Request;
use App\Repositories\Belanja\SPPRepository;
use App\Repositories\BKU\BKURincianRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\Pengembalian\KontraposRepository;
use App\Repositories\RBA\RBAIndikatorKerjaRepository;
use App\Repositories\RBA\RBARincianAnggaranRepository;
use App\Repositories\RBA\RBARincianSumberDanaRepository;
use App\Repositories\StatusAnggaran\StatusAnggaranRepository;

class RBA221Controller extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Kegiatan repository.
     * 
     * @var KegiatanRepository
     */
    private $kegiatan;

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $sumberDana;

     /**
     * Unit kerja repository.
     * 
     * @var RBARincianAnggaran
     */
    private $rincianAnggaran;

    /**
     * Unit kerja repository.
     * 
     * @var RBARincianSumberDana
     */
    private $rincianSumberDana;

    /**
     * Unit kerja repository.
     * 
     * @var RBAIndikatorKerjaRepository
     */
    private $indikatorKerja;

    /**
     * Unit kerja repository.
     * 
     * @var UserRepository
     */
    private $user;

    /**
     * SPP Repository
     *
     * @var SPPRepository
     */
    private $spp;

    /**
     * BKURincianRepository
     *
     * @var BKURincianRepository
     */
    private $bkuRincian;

    /**
     * PejabatUnitRepository
     *
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;
    
    /**
     * Status anggaran repository
     * 
     * @var StatusAnggaranRepository
     */
    private $statusAnggaran;

     /**
     * Construct.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        RBARepository $rba,
        AkunRepository $akun,
        SumberDanaRepository $sumberDana,
        RBARincianAnggaranRepository $rincianAnggaran,
        RBARincianSumberDanaRepository $rincianSumberDana,
        RBAIndikatorKerjaRepository $indikatorKerja,
        KegiatanRepository $kegiatan,
        UserRepository $user,
        SPPRepository $spp,
        BKURincianRepository $bkuRincian,
        PejabatUnitRepository $pejabatUnit,
        StatusAnggaranRepository $statusAnggaran
    ) {
        $this->unitKerja = $unitKerja;
        $this->rba = $rba;
        $this->akun = $akun;
        $this->sumberDana = $sumberDana;
        $this->rincianAnggaran = $rincianAnggaran;
        $this->rincianSumberDana = $rincianSumberDana;
        $this->indikatorKerja = $indikatorKerja;
        $this->kegiatan = $kegiatan;
        $this->user = $user;
        $this->spp = $spp;
        $this->bkuRincian = $bkuRincian;
        $this->pejabatUnit = $pejabatUnit;
        $this->statusAnggaran = $statusAnggaran;
        $this->opd = [
            'kode' => '1.02.01',
            'nama_opd' => 'DINAS KESEHATAN'
        ];

        $this->fields = [
            'unitKerja' => 'unitKerja:kode,nama_unit',
            'mapKegiatan' => 'mapKegiatan.blud:id,kode,kode_bidang,kode_program,nama_kegiatan',
            'rincianAnggaran.akun' => 'rincianAnggaran.akun:id,tipe,kelompok,jenis,objek,rincian,sub1,sub2,sub3,kode_akun,nama_akun,kategori_id,pagu,is_parent',
            'rincianAnggaran.ssh' => 'rincianAnggaran.ssh:id,golongan,bidang,kelompok,sub1,sub2,sub3,sub4,kode,kode_akun,nama_barang,satuan,merk,spesifikasi,harga',
            'pejabatUnit.jabatan' => 'pejabatUnit.jabatan:id,nama_jabatan',
            'rincianSumberDana.sumberDana' => 'rincianSumberDana.sumberDana:id,nama_sumber_dana,nama_bank,no_rekening',
            'statusAnggaran' => 'statusAnggaran:id,status_anggaran'
        ];
    }

    public function index(Request $request, $tipe)
    {
        try {
            $qsUnitKerja = $request->query('unit_kerja');
    
            $whereRba = function ($query) use($tipe, $qsUnitKerja){
                $query->where('kode_rba', Rba::KODE_RBA_221)
                    ->where('tipe', $tipe);
    
                if ($qsUnitKerja){
                    $query->where('kode_unit_kerja', $qsUnitKerja);
                }
            };

            $paginateResult = $this->getRba221($request, $whereRba);
    
            return response()->json($paginateResult, 200);
        } catch(\Exception $exception) {
            dd($exception);
            // report($exception);
            // return response()->json([
            //     'message' => $exception->message ?? 'Terdapat kesalahan pada server',
            //     'data' => $exception
            // ], 400);
        }
    }

    public function statusAnggaran(Request $request, $status)
    {
        try {
            $qsUnitKerja = $request->query('unit_kerja');

            $whereStatusAnggaran = function ($query) use($status){
                $query->where('id', $status);
            };
            $statusAnggaran = $this->statusAnggaran->get(['*'], $whereStatusAnggaran)->first();

            if(!$statusAnggaran) {
                throw new \Exception('Status anggaran tidak ditemukan.');
            }

            $whereRba = function ($query) use($statusAnggaran, $qsUnitKerja){
                $query->where('kode_rba', Rba::KODE_RBA_221)
                    ->where('status_anggaran_id', $statusAnggaran->id);
    
                if ($qsUnitKerja){
                    $query->where('kode_unit_kerja', $qsUnitKerja);
                }
            };

            $paginateResult = $this->getRba221($request, $whereRba);
    
            return response()->json($paginateResult, 200);
            
        } catch(\Exception $exception) {
            // dd($exception);
            // report($exception);
            return response()->json([
                'message' => $exception->getMessage() ?? 'Terdapat kesalahan pada server',
                'data' => $exception
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $whereAkun = function ($query){
                $query->where('tipe', 5);
            };
            $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');
    
            $whereRba = function ($query) use($id){
                $query->where('kode_rba', Rba::KODE_RBA_221)
                    ->where('id', '<>', $id);
            };
    
            $rba221 = $this->rba->get(['*'], $whereRba);
    
            $kodeUnitKerja = $rba221->pluck('kode_unit_kerja');
    
            $whereUnitKerja = function ($query) use ($kodeUnitKerja){
                $query->where('kode', $kodeUnitKerja);
            };
            
            $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);
    
            $akunTipe = 5;
            $whereAkunParent = function ($query) use ($akunTipe) {
                $query->where('tipe', $akunTipe)
                    ->where('is_parent', true);
            };
            $akunParent = $this->akun->get(['*'], $whereAkunParent);
    
            $this->rba->makeModel();
    
            $fields = [
                'id', 'kode_unit_kerja', 'tipe', 'map_kegiatan_id', 'pejabat_id',
                'kelompok_sasaran', 'latar_belakang', 'created_at', 'updated_at'
            ];
    
            $rba = $this->rba->findBy(
                'id',
                '=',
                $id,
                $fields,
                [
                    $this->fields['unitKerja'], 
                    $this->fields['rincianAnggaran.akun'], 
                    $this->fields['rincianAnggaran.ssh'], 
                    $this->fields['rincianSumberDana.sumberDana'], 
                    'indikatorKerja',
                    $this->fields['pejabatUnit.jabatan'],
                    $this->fields['mapKegiatan']
                ]
            );
            
            $whereSpp = function ($query) use ($rba) {
                $query->where('kode_unit_kerja', $rba->kode_unit_kerja);
            };
            $realisasiSpp = $this->spp->get(['*'], $whereSpp, ['bast.rincianPengadaan']);
    
            $realisasi = [];
    
            foreach ($realisasiSpp as $value) {
                foreach ($value->bast->rincianPengadaan as $item) {
                    array_push($realisasi, [
                        'kode_akun' => $item->kode_akun,
                        'total' => $item->unit * $item->harga
                    ]);
                }
            }
            $realisasi = collect($realisasi);
    
            $kodeAkunRealisasi = clone $realisasi;
            $kodeAkunRealisasi = $kodeAkunRealisasi->pluck('kode_akun');
    
            $kontrapos = $this->bkuRincian->getKontraposBku($rba->kode_unit_kerja, $kodeAkunRealisasi);
    
            $kontraposData = $kontrapos->pluck('nominal', 'kode_akun');
    
            foreach($realisasi as $key => $item){
                if (isset($kontraposData[$item['kode_akun']])){
                    $realisasi[$key] = [
                        'kode_akun' => $item['kode_akun'],
                        'total' => $item['total'] - $kontraposData[$item['kode_akun']]
                    ];
                }
            }
    
            // get all kode akun on rincian rba
            $allKodeAkunRba = [];
            foreach($rba->rincianAnggaran as $rincian){
                array_push($allKodeAkunRba, $rincian->akun->kode_akun);
            }
    
            // get unique kode akun 
            $dataKode = [];
            foreach ($allKodeAkunRba as $item) {
                $kode = substr($item, 0, 8);
                if (! in_array($kode, $dataKode)) {
                    $dataKode[] = $kode;
                }
            }
    
            // get parent from unique kode akun
            $kodeParent = [];
            foreach($dataKode as $kode){
                $explode = explode('.', $kode);
                $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
                foreach ($parents as $akunParent) {
                    array_push($kodeParent, $akunParent);
                }
            }
            $whereAllKodeAKun = collect($allKodeAkunRba)->merge(collect($kodeParent));
    
            $this->akun->makeModel();
    
            // get all parent and kode akun data
            $whereRba221 = function ($query) use($whereAllKodeAKun){
                $query->whereIn('kode_akun', $whereAllKodeAKun)
                    ->orderBy('kode_akun');
            };
    
            $akunRba221 = $this->akun->get(['*'], $whereRba221);
            $akunRba221->map(function ($item) use ($realisasi) {
                $item->realisasi = 0;
                foreach ($realisasi as $data) {
                    if ($data['kode_akun'] == $item->kode_akun) {
                        $item->realisasi = $data['total'];
                    }
                }
            });
            
            /** Hidden attributes */
            $timestampHidden = ['created_at', 'deleted_at', 'updated_at'];
            
            $rba->makeHidden('kode_unit_kerja');
            
            $rba['rincianAnggaran']->each(function ($item) use ($timestampHidden) {
                $item->makeHidden( array_merge([
                    'rba_id', 'akun_id', 'ssh_id'
                    ], $timestampHidden
                ));
            });
            
            $rba['rincianSumberDana']->each(function ($item) use ($timestampHidden) {
                $item->nominal = floatval($item->nominal);
                $item->nominal_pak = floatval($item->nominal_pak);
                $item->makeHidden( array_merge([
                    'rba_id', 'sumber_dana_id'
                    ], $timestampHidden
                ));
            });
            
            $rba['indikatorKerja']->each(function ($item) use ($timestampHidden) {
                $item->makeHidden( array_merge([
                    'rba_id'
                    ], $timestampHidden
                ));
            });
    
            
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
            $rba->opd = $this->opd;
            
            $rba->makeHidden('mapKegiatan');
            $rba->map_kegiatan = $rba['mapKegiatan']['blud'];
    
            $rba->makeHidden('pejabatUnit');
            $rba->pejabat_unit = [
                'id' => $rba['pejabatUnit']->id,
                'nama_pejabat' => $rba['pejabatUnit']->nama_pejabat,
                'nip' => $rba['pejabatUnit']->nip,
                'status' => $rba['pejabatUnit']->status,
                'jabatan' => $rba['pejabatUnit']['jabatan']
            ];
            
            return response()->json([
                'data' => $rba
            ], 200);
        } catch(\Exception $exception) {
            report($exception);
            return response()->json([
                'message' => $exception->getMessage() ?? 'Terdapat kesalahan pada server',
                'data' => $exception
            ], 400);
        }
    }

    private function getRba221($request, $whereRba) {
        $currentPage = $request->query('page') ?? 1;
        $perPage = 10;

        $fields = [
            'id', 'kode_unit_kerja', 'map_kegiatan_id', 'status_anggaran_id',
            'kelompok_sasaran', 'latar_belakang', 'created_at', 'updated_at',
        ];
        
        $rba = $this->rba->paginate($perPage, $currentPage, $fields, $whereRba, [
            $this->fields['unitKerja'], 
            'rincianSumberDana', 
            $this->fields['statusAnggaran'],
            $this->fields['mapKegiatan']
        ], 'created_at');
        
        $rba->sum(function ($rba){
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
        });

        
        $paginateResult = $rba->appends($request->except('page'));
        
        $paginateData = $paginateResult->getCollection();
        $paginateData->each(function ($item) {
            $item->status_anggaran = $item->statusAnggaran();
            $item->opd = $this->opd;
            $item->makeHidden('rincianSumberDana');
            $item->makeHidden('kode_unit_kerja');
            $item->makeHidden('mapKegiatan');
            $item->map_kegiatan = $item['mapKegiatan']['blud'];
        });
        $paginateResult->setCollection($paginateData);

        return $paginateResult;
    }
}
