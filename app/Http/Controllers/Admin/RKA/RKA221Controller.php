<?php

namespace App\Http\Controllers\Admin\RKA;

use App\Models\Rka;
use App\Models\Ssh;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\RKA\RKARepository;
use App\Http\Requests\RKA\RKA221Request;
use App\Repositories\User\UserRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\MapSubKegiatanRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RKA\RKAIndikatorKerjaRepository;
use App\Repositories\RKA\RKARincianAnggaranRepository;
use App\Repositories\RKA\RKARincianSumberDanaRepository;

class RKA221Controller extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var RKARepository
     */
    private $rka;

    /**
     * Unit Kerja Repository.
     *
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Akun Repository.
     *
     * @var AkunRepository
     */
    private $akun;

    /**
     * User Repository.
     *
     * @var UserRepository
     */
    private $user;

    /**
     * Rka Rincian anggaran Repository.
     *
     * @var RkaRincianAnggaranRepository
     */
    private $rincianAnggaran;

    /**
     * Rka Rincian sumber dana Repository.
     *
     * @var RkaRincianSumberDanaRepository
     */
    private $rincianSumberDana;

    /**
     * Rka Rincian sumber dana Repository.
     *
     * @var RkaIndikatorKerja
     */
    private $indikatorKerja;
    private $mapSubKegiatan;

    /**
     * Constructor.
     * 
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        AkunRepository $akun,
        RKARepository $rka,
        UserRepository $user,
        RKARincianAnggaranRepository $rincianAnggaran,
        RKARincianSumberDanaRepository $rincianSumberDana,
        RKAIndikatorKerjaRepository $indikatorKerja,
        MapSubKegiatanRepository $mapSubKegiatan
    ) {
        $this->unitKerja            = $unitKerja;
        $this->akun                 = $akun;
        $this->rka                  = $rka;
        $this->user                 = $user;
        $this->rincianAnggaran      = $rincianAnggaran;
        $this->rincianSumberDana    = $rincianSumberDana;
        $this->indikatorKerja       = $indikatorKerja;
        $this->mapSubKegiatan       = $mapSubKegiatan;

        // $this->middleware('permission:buat RKA')->only('create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitKerja = $this->unitKerja->get();

        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereRka = function ($query) use($user, $request){
            $query->where('kode_rka', Rka::KODE_RKA_221);
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
        $rka = $this->rka->get(['*'], $whereRka, ['mapKegiatan.blud']);
        $rka->sum(function ($rka){
            $rka->total_nominal_murni = $rka->rincianSumberDana->sum('nominal');
            $rka->total_nominal_pak = $rka->rincianSumberDana->sum('nominal_pak');
        });

        $totalAllRka221Murni = $rka->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal');
        });

        $totalAllRka221Pak = $rka->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal_pak');
        });

        $totalAllRka = [
            'murni' => $totalAllRka221Murni,
            'pak' => $totalAllRka221Pak
        ];

        $rka = $rka->sortByDesc('created_at');

        return view('admin.rka.rka221.index', compact('rka', 'totalAllRka', 'unitKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user           = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        $mapSubKegiatan = $this->mapSubKegiatan->get();

        $whereAkun = function ($query) {
            // $query->where('tipe', 5)
            //     ->whereNull('kelompok')
            //     ->orWhere(function ($q) {
            //         $q->where('tipe', 5)
            //             ->where('kelompok', 2);
            //     });
            $query->where('tipe', 5);
                // ->whereNull('kelompok')
                // ->orWhere(function ($q) {
                //     $q->where('tipe', 5)
                //         ->where('kelompok', 2)
                // });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRka = function ($query){
            $query->where('kode_rka', Rka::KODE_RKA_221);
        };

        $rka221 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka221->pluck('kode_unit_kerja')->toArray();

        $whereUnitKerja = function ($query) use ($user, $kodeUnitKerja){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            // if (count($kodeUnitKerja) > 0){
            //     $query->whereNotIn('kode', $kodeUnitKerja);
            // }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        return view('admin.rka.rka221.create', compact('unitKerja', 'akun', 'mapSubKegiatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RKA221Request $request)
    {
         try {
            DB::beginTransaction();
            $rka = $this->rka->create([
                'kode_rka' => Rka::KODE_RKA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->kegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'status_anggaran_id' => auth()->user()->statusAnggaran->id,
            ]);

            if (!$rka)
                throw new \Exception('create rka error');
                
            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => parse_format_number($request->tarif[$key]), 
                    'tahun_berikutnya' => $request->jumlah_tahun[$key], 
                    'keterangan' => $request->keterangan[$key]
                ]);
                 if (!$rkaRincianAnggaran)
                    throw new \Exception('create rba rincian anggaran error');
            }

            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rka->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rkaRincianSumberDana = $this->rincianSumberDana->create([
                     'rka_id' => $rka->id, 
                     'akun_id' => $akun->id, 
                     'sumber_dana_id' => $request->sumber_dana[$key], 
                     'nominal' => parse_format_number($request->nominal[$key]),
                ]);

                if (!$rkaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data) {
                $rkaIndikatorKerja = $this->indikatorKerja->create([
                    'rka_id' => $rka->id,
                    'jenis_indikator' => $request->jenis_indikator[$key],
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key],
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rkaIndikatorKerja)
                    throw new \Exception('create rba indikator kinerja error');
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'rka' => $rka], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $kode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereAkun = function ($query) {
            $query->where('tipe', 5)
                ->whereNull('kelompok')
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 2);
                });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRka = function ($query) use ($user, $id) {
            $query->where('kode_rka', Rka::KODE_RKA_221)
                ->where('id', '<>', $id)
                ->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS) {
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rka221 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka221->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user) {
            if ($user->role->role_name == Role::ROLE_PUSKESMAS) {
                $query->where('kode', $user->unitKerja->kode);
            }
            // if (count($kodeUnitKerja) > 0) {
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

        $this->rka->makeModel();

        $rka = $this->rka->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh', 'rincianSumberDana', 'indikatorKerja']
        );

        // get all kode akun on rincian rba
        $allKodeAkunrka = [];
        foreach ($rka->rincianAnggaran as $rincian) {
            array_push($allKodeAkunrka, $rincian->akun->kode_akun);
        }

        // get unique kode akun 
        $dataKode = [];
        foreach ($allKodeAkunrka as $item) {
            $kode = substr($item, 0, 8);
            if (!in_array($kode, $dataKode)) {
                $dataKode[] = $kode;
            }
        }

        // get parent from unique kode akun
        $kodeParent = [];
        foreach ($dataKode as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParent, $akunParent);
            }
        }
        $whereAllKodeAKun = collect($allKodeAkunrka)->merge(collect($kodeParent));

        $this->akun->makeModel();

        // get all parent and kode akun data
        $whereRka221 = function ($query) use ($whereAllKodeAKun) {
            $query->whereIn('kode_akun', $whereAllKodeAKun)
                ->orderBy('kode_akun');
        };

        $akunRka221 = $this->akun->get(['*'], $whereRka221);

        $indikatorKerja = [
            'input' => $rka->indikatorKerja->where('jenis_indikator', 'Input')->first(),
            'output' => $rka->indikatorKerja->where('jenis_indikator', 'Output')->first(),
            'outcame' => $rka->indikatorKerja->where('jenis_indikator', 'Outcame')->first(),
        ];

        $ssh = new Ssh();
        $oldSumberDana = [];
        foreach ($rka->rincianSumberDana as $sumberDana) {
            $oldSumberDana[] = [
                'kode_akun' => $sumberDana->akun->kode_akun,
                'sumber_dana' => $sumberDana->sumber_dana_id
            ];
        }
        $oldSumberDana = json_encode($oldSumberDana);

        return view('admin.rka.rka221.edit', compact('unitKerja', 'akun', 'rka', 'akunParent', 'indikatorKerja', 'ssh', 'akunRka221', 'allKodeAkunrka', 'oldSumberDana'));
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

        $whereAkun = function ($query) {
            $query->where('tipe', 5)
                ->whereNull('kelompok')
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 2);
                });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRka = function ($query) use($user, $id){
            $query->where('kode_rka', Rka::KODE_RKA_221)
                ->where('id', '<>', $id)
                ->where('tipe', auth()->user()->status);
            
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rka221 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka221->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            // if (count($kodeUnitKerja) > 0) {
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

        $this->rka->makeModel();

        $rka = $this->rka->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh', 'rincianSumberDana', 'indikatorKerja']
        );

        // get all kode akun on rincian rba
        $allKodeAkunRka = [];
        foreach($rka->rincianAnggaran as $rincian){
            array_push($allKodeAkunRka, $rincian->akun->kode_akun);
        }

        // get unique kode akun 
        $dataKode = [];
        foreach ($allKodeAkunRka as $item) {
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
        $whereAllKodeAKun = collect($allKodeAkunRka)->merge(collect($kodeParent));

        $this->akun->makeModel();

        // get all parent and kode akun data
        $whereRka221 = function ($query) use($whereAllKodeAKun){
            $query->whereIn('kode_akun', $whereAllKodeAKun)
                ->orderBy('kode_akun');
        };

        $akunRka221 = $this->akun->get(['*'], $whereRka221);

        $indikatorKerja = [
            'input' => $rka->indikatorKerja->where('jenis_indikator', 'Input')->first(),
            'output' => $rka->indikatorKerja->where('jenis_indikator', 'Output')->first(),
            'outcame' => $rka->indikatorKerja->where('jenis_indikator', 'Outcame')->first(),
        ];

        $ssh = new Ssh();

        return view('admin.rka.rka221.pak.edit', compact('unitKerja', 'akun', 'rka', 'akunParent', 'indikatorKerja', 'ssh', 'akunRka221', 'allKodeAkunRka'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RKA221Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rka = $this->rka->find($id);
            if (!$rka) {
                throw new \Exception('Rka not found');
            }

            $this->rka->update([
                'kode_rka' => Rka::KODE_RKA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->kegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rka->id);
            $this->rincianSumberDana->deleteAll($rka->id);
            $this->indikatorKerja->deleteAll($rka->id);

            for ($key = 0; $key < count($request->kode_rekening); $key++) {
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key],
                    'volume' => $request->volume[$key],
                    'tarif' => parse_format_number($request->tarif[$key]),
                    'tahun_berikutnya' => $request->jumlah_tahun[$key],
                    'keterangan' => $request->keterangan[$key]
                ]);
                if (!$rkaRincianAnggaran)
                    throw new \Exception('create rka rincian anggaran error');
            }

            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rka->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rkaRincianSumberDana = $this->rincianSumberDana->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key]),
                ]);

                if (!$rkaRincianSumberDana)
                    throw new \Exception('create rka rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data) {
                $rkaIndikatorKerja = $this->indikatorKerja->create([
                    'rka_id' => $rka->id,
                    'jenis_indikator' => $request->jenis_indikator[$key],
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key],
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rkaIndikatorKerja)
                    throw new \Exception('create rka indikator kinerja error');
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'rka' => $rka], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'data' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePak(RKA221Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rka = $this->rka->find($id);
            if (!$rka) {
                throw new \Exception('Rka not found');
            }

            $this->rka->update([
                'kode_rka' => Rka::KODE_RKA_221,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'kelompok_sasaran' => $request->sasaran_kegiatan,
                'map_kegiatan_id' => $request->kegiatan,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rka->id);
            $this->rincianSumberDana->deleteAll($rka->id);
            $this->indikatorKerja->deleteAll($rka->id);

            for ($key = 0; $key < count($request->kode_rekening); $key++) {
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'ssh_id' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key],
                    'volume' => $request->volume[$key],
                    'tarif' => parse_format_number($request->tarif[$key]),
                    'satuan_pak' => $request->satuan_pak[$key],
                    'volume_pak' => $request->volume_pak[$key],
                    'tarif_pak' => parse_format_number($request->tarif_pak[$key]),
                    
                ]);
                if (!$rkaRincianAnggaran)
                    throw new \Exception('create rka rincian anggaran error');
            }

            foreach ($request->sumber_dana as $key => $data) {
                $akun = $this->rka->getAkunId($request->kode_rekening_sumber_dana[$key]);
                $rkaRincianSumberDana = $this->rincianSumberDana->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'sumber_dana_id' => $request->sumber_dana[$key],
                    'nominal' => parse_format_number($request->nominal[$key]),
                    'nominal_pak' => parse_format_number($request->nominal_pak[$key]),
                ]);

                if (!$rkaRincianSumberDana)
                    throw new \Exception('create rka rincian sumber dana error');
            }

            foreach ($request->jenis_indikator as $key => $data) {
                $rkaIndikatorKerja = $this->indikatorKerja->create([
                    'rka_id' => $rka->id,
                    'jenis_indikator' => $request->jenis_indikator[$key],
                    'tolak_ukur_kerja' => $request->tolak_ukur_kinerja[$key],
                    'target_kerja' => $request->target_kinerja[$key]
                ]);

                if (!$rkaIndikatorKerja)
                    throw new \Exception('create rka indikator kinerja error');
            }

            DB::commit();
            return response()->json(['status' => 'oke', 'rka' => $rka], 200);
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
        $this->rka->delete($request->id);
        return redirect()->back()
            ->with(['success' => 'Data berhasil dihapus']);
    }
}
