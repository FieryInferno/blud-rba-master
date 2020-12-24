<?php

namespace App\Http\Controllers\Admin\RBA;

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
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\DataDasar\MapSubKegiatanRepository;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Pengembalian\KontraposRepository;
use App\Repositories\RBA\RBAIndikatorKerjaRepository;
use App\Repositories\RBA\RBARincianAnggaranRepository;
use App\Repositories\RBA\RBARincianSumberDanaRepository;

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
     * Map Kegiatan Repository
     *
     * @var MapKegiatanRepository
     */
    private $pemetaanKegiatan;
    private $mapSubKegiatan;

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
        MapKegiatanRepository $pemetaanKegiatan,
        MapSubKegiatanRepository $mapSubKegiatan
    ) {
        $this->unitKerja            = $unitKerja;
        $this->rba                  = $rba;
        $this->akun                 = $akun;
        $this->sumberDana           = $sumberDana;
        $this->rincianAnggaran      = $rincianAnggaran;
        $this->rincianSumberDana    = $rincianSumberDana;
        $this->indikatorKerja       = $indikatorKerja;
        $this->kegiatan             = $kegiatan;
        $this->user                 = $user;
        $this->spp                  = $spp;
        $this->bkuRincian           = $bkuRincian;
        $this->pemetaanKegiatan     = $pemetaanKegiatan;
        $this->mapSubKegiatan       = $mapSubKegiatan;
        // $this->middleware('permission:buat RBA')->only('create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user               = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        $unitKerja          = $this->unitKerja->get();

        $whereRba = function ($query) use ($user, $request) {
            $query->where('kode_rba', Rba::KODE_RBA_221);
            $query->where('status_anggaran_id', auth()->user()->statusAnggaran->id);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }

            if ($request->unit_kerja) {
                $query->where('kode_unit_kerja', $request->unit_kerja);
            }

            if ($request->start_date) {
                $query->where('created_at', '>=', $request->start_date);
            }

            if ($request->end_date) {
                $query->where('created_at', '<=', $request->end_date);
            }
        };
        $rba = $this->rba->get(['*'], $whereRba, ['unitKerja', 'rincianSumberDana', 'mapSubKegiatan.subKegiatanBlud']);
        $rba->sum(function ($rba){
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
        });
        
        $rba = $rba->sortByDesc('created_at');

        $totalAllRba221Murni = $rba->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal');
        });

        $totalAllRba221Pak = $rba->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal_pak');
        });

        $totalAllRba = [
            'murni' => $totalAllRba221Murni,
            'pak' => $totalAllRba221Pak
        ];

        return view('admin.rba.rba221.index', compact('rba', 'unitKerja', 'totalAllRba'));
    }

    /**
     * create
     *
     * @param [String] $kodeUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user               = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereAkun = function ($query){
            $query->where('tipe', 5);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query){
            $query->where('kode_rba', Rba::KODE_RBA_221);
        };

        $rba221 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba221->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($user, $kodeUnitKerja){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            // $query->whereNotIn('kode', $kodeUnitKerja);
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        return view('admin.rba.rba221.create', compact('unitKerja', 'akun'));
    }

    /**
     * Store
     *
     * @return void
     */
    public function store(RBA221Request $request)
    {
        try {
            DB::beginTransaction();
            $rba = $this->rba->create([
                'kode_rba' => Rba::KODE_RBA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'latar_belakang' => $request->latar_belakang,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->subKegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'status_anggaran_id' => auth()->user()->statusAnggaran->id,
            ]);

            if (!$rba)
                throw new \Exception('create rba error');
                
            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => parse_format_number($request->tarif[$key]), 
                    'tahun_berikutnya' => $request->jumlah_tahun[$key], 
                    'keterangan' => $request->keterangan[$key]
                ]);
                if (!$rbaRincianAnggaran)
                    throw new \Exception('create rba rincian anggaran error');
            }
            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rba->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rbaRincianSumberDana = $this->rincianSumberDana->create([
                    'rba_id' => $rba->id, 
                    'akun_id' => $akun->id, 
                    'sumber_dana_id' => $request->sumber_dana[$key], 
                    'nominal' => parse_format_number($request->nominal[$key]),
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data){
                $rbaIndikatorKerja = $this->indikatorKerja->create([
                    'rba_id' => $rba->id, 
                    'jenis_indikator' => $request->jenis_indikator[$key], 
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key], 
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rbaIndikatorKerja)
                    throw new \Exception('create rba indikator kinerja error');
            }
            DB::commit();
            return response()->json(['status' => 'oke', 'rba' => $rba], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }   
    }

    /**
     * Edit
     *
     * @param string $kode
     * @return void
     */
    public function edit($id)
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereAkun = function ($query){
            $query->where('tipe', 5);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user, $id){
            $query->where('kode_rba', Rba::KODE_RBA_221)
                ->where('id', '<>', $id)
                ->where('status_anggaran_id', auth()->user()->statusAnggaran->id);
            
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba221 = $this->rba->get(['*'], $whereRba);

        $kodeUnitKerja = $rba221->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            // if (count($kodeUnitKerja) > 0){
            //     $query->whereNotIn('kode', $kodeUnitKerja);
            // }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        $akunTipe = 5;
        $whereAkunParent = function ($query) use ($akunTipe) {
            $query->where('tipe', $akunTipe)
                ->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        $this->rba->makeModel();

        $rba = $this->rba->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh', 'rincianSumberDana', 'indikatorKerja']
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
            $kode = substr($item, 0, 13);
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

        $indikatorKerja = [
            'input' => $rba->indikatorKerja->where('jenis_indikator', 'Input')->first(),
            'output' => $rba->indikatorKerja->where('jenis_indikator', 'Output')->first(),
            'outcame' => $rba->indikatorKerja->where('jenis_indikator', 'Outcame')->first(),
        ];

        $ssh = new Ssh();
        $oldSumberDana = [];
        foreach ($rba->rincianSumberDana as $sumberDana) {
            $oldSumberDana[] = [
                'kode_akun' => $sumberDana->akun->kode_akun,
                'sumber_dana' => $sumberDana->sumber_dana_id
            ];
        }
        $oldSumberDana = json_encode($oldSumberDana);

        return view('admin.rba.rba221.edit', compact(
            'unitKerja', 'akun', 'rba', 'akunParent', 'indikatorKerja', 'ssh', 'akunRba221', 'allKodeAkunRba', 'oldSumberDana',
            'realisasi'
        ));
    }

    /**
     * Edit PAK
     *
     * @param string $kode
     * @return void
     */
    public function editPak($id)
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereAkun = function ($query){
            $query->where('tipe', 5);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user, $id){
            $query->where('kode_rba', Rba::KODE_RBA_221)
                ->where('id', '<>', $id)
                ->where('status_anggaran_id', auth()->user()->statusAnggaran->id);
            
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba221 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba221->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            // if (count($kodeUnitKerja) > 0){
            //     $query->whereNotIn('kode', $kodeUnitKerja);
            // }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        $akunTipe = 5;
        $whereAkunParent = function ($query) use ($akunTipe) {
            $query->where('tipe', $akunTipe);
            $query->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        $this->rba->makeModel();

        $rba = $this->rba->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh', 'rincianSumberDana', 'indikatorKerja']
        );

        $whereSpp = function ($query) use ($rba) {
            $query->where('kode_unit_kerja', $rba->kode_unit_kerja);
        };
        $realisasiSpp = $this->spp->get(['*'], $whereSpp, ['bast.rincianPengadaan']);

        $realisasi = [];

        foreach ($realisasiSpp as $value){
            foreach ($value->bast->rincianPengadaan as $item){
                array_push($realisasi, [
                    'kode_akun' => $item->kode_akun,
                    'total'=> $item->unit * $item->harga
                ]);
            }
        }
        $realisasi = collect($realisasi);

        $kodeAkunRealisasi = clone $realisasi;
        $kodeAkunRealisasi = $kodeAkunRealisasi->pluck('kode_akun');

        $kontrapos = $this->bkuRincian->getKontraposBku($rba->kode_unit_kerja, $kodeAkunRealisasi);

        $kontraposData = $kontrapos->pluck('nominal', 'kode_akun');

        foreach ($realisasi as $key => $item) {
            if (isset($kontraposData[$item['kode_akun']])) {
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
        $akunRba221->map(function ($item) use($realisasi) {
            $item->realisasi = 0;
            foreach ($realisasi as $data){
                if ($data['kode_akun'] == $item->kode_akun) {
                    $item->realisasi = $data['total'];
                }
            }
        });

        $indikatorKerja = [
            'input' => $rba->indikatorKerja->where('jenis_indikator', 'Input')->first(),
            'output' => $rba->indikatorKerja->where('jenis_indikator', 'Output')->first(),
            'outcame' => $rba->indikatorKerja->where('jenis_indikator', 'Outcame')->first(),
        ];

        $ssh = new Ssh();
        $oldSumberDana = [];
        foreach ($rba->rincianSumberDana as $sumberDana) {
            $oldSumberDana[] = [
                'kode_akun' => $sumberDana->akun->kode_akun,
                'sumber_dana' => $sumberDana->sumber_dana_id
            ];
        }
        $oldSumberDana = json_encode($oldSumberDana);

        return view('admin.rba.rba221.pak.edit', compact(
            'unitKerja', 'akun', 'rba', 'akunParent', 'indikatorKerja', 'ssh', 'akunRba221', 'oldSumberDana',
            'realisasi', 'allKodeAkunRba'
        ));
    }

    /**
     * Update RBA 221
     *
     * @param RBA221Request $request
     * @param [type] $id
     * @return void
     */
    public function update(RBA221Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba){
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'latar_belakang' => $request->latar_belakang,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->kegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rba->id);
            $this->rincianSumberDana->deleteAll($rba->id);
            $this->indikatorKerja->deleteAll($rba->id);

            for($key = 0; $key < count($request->kode_rekening); $key++){
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => parse_format_number($request->tarif[$key]), 
                    'tahun_berikutnya' => 0, 
                    'keterangan' => $request->keterangan[$key]
                ]);
                 if (!$rbaRincianAnggaran)
                    throw new \Exception('create rba rincian anggaran error');
            }

            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rba->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rbaRincianSumberDana = $this->rincianSumberDana->create([
                     'rba_id' => $rba->id, 
                     'akun_id' => $akun->id, 
                     'sumber_dana_id' => $request->sumber_dana[$key], 
                     'nominal' => parse_format_number($request->nominal[$key]),
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data){
                $rbaIndikatorKerja = $this->indikatorKerja->create([
                    'rba_id' => $rba->id, 
                    'jenis_indikator' => $request->jenis_indikator[$key], 
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key], 
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rbaIndikatorKerja)
                    throw new \Exception('create rba indikator kinerja error');
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'rba' => $rba], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 400);
        }
    }

    /**
     * Update RBA 221 PAK
     *
     * @param RBA221Request $request
     * @param [type] $id
     * @return void
     */
    public function updatePak(RBA221Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba) {
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'latar_belakang' => $request->latar_belakang,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->kegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rba->id);
            $this->rincianSumberDana->deleteAll($rba->id);
            $this->indikatorKerja->deleteAll($rba->id);

            for ($key = 0; $key < count($request->kode_rekening); $key++) {
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key],
                    'volume' => $request->volume[$key],
                    'tarif' => parse_format_number($request->tarif[$key]),
                    'satuan_pak' => $request->satuan_pak[$key],
                    'volume_pak' => $request->volume_pak[$key],
                    'tarif_pak' => parse_format_number($request->tarif_pak[$key]),
                    
                ]);
                if (!$rbaRincianAnggaran)
                    throw new \Exception('create rba rincian anggaran error');
            }

            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rba->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rbaRincianSumberDana = $this->rincianSumberDana->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key]),
                    'nominal_pak' => parse_format_number($request->nominal_pak[$key])
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data) {
                $rbaIndikatorKerja = $this->indikatorKerja->create([
                    'rba_id' => $rba->id,
                    'jenis_indikator' => $request->jenis_indikator[$key],
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key],
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rbaIndikatorKerja)
                    throw new \Exception('create rba indikator kinerja error');
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'rba' => $rba], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->rba->delete($request->id);
        return redirect()->back()
            ->with(['success' => 'Data berhasil dihapus']);
    }
}
