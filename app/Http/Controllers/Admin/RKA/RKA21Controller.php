<?php

namespace App\Http\Controllers\Admin\RKA;

use App\Models\Rka;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RKA\RKA1Request;
use App\Http\Requests\RKA\RKA21Request;
use App\Repositories\RKA\RKARepository;
use App\Repositories\User\UserRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RKA\RKARincianAnggaranRepository;
use App\Repositories\RKA\RKARincianSumberDanaRepository;

class RKA21Controller extends Controller
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
     * Constructor.
     * 
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        AkunRepository $akun,
        RKARepository $rka,
        UserRepository $user,
        RKARincianAnggaranRepository $rincianAnggaran,
        RKARincianSumberDanaRepository $rincianSumberDana
    ) {
        $this->unitKerja = $unitKerja;
        $this->akun = $akun;
        $this->rka = $rka;
        $this->user = $user;
        $this->rincianAnggaran = $rincianAnggaran;
        $this->rincianSumberDana =$rincianSumberDana;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereRka = function ($query) use($user){
            $query->where('kode_rka', Rka::KODE_RKA_21);
            $query->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }

        };
        $rka = $this->rka->get(['*'], $whereRka);
        $rka->sum(function ($rka){
            $rka->total_nominal_murni = $rka->rincianSumberDana->sum('nominal');
            $rka->total_nominal_pak = $rka->rincianSumberDana->sum('nominal_pak');
        });

        $rka = $rka->sortByDesc('created_at');

        return view('admin.rka.rka21.index', compact('rka'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        
        $whereAkun = function ($query){
            $query->where('tipe', 5)
                ->where('kode_akun', '<', '5.1.2')
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 1)
                        ->where('jenis', 1);
                });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRka = function ($query) {
            $query->where('kode_rka', Rka::KODE_RKA_21);
        };

        $rka21 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka21->pluck('kode_unit_kerja')->toArray();

        $whereUnitKerja = function ($query) use ($user, $kodeUnitKerja){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }

            if (count($kodeUnitKerja) > 0){
                $query->whereNotIn('kode', $kodeUnitKerja);
            }
        };

        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);
        return view('admin.rka.rka21.create', compact('unitKerja', 'akun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RKA21Request $request)
    {
         try {
            DB::beginTransaction();
            $rka = $this->rka->create([
                'kode_rka' => Rka::KODE_RKA_21,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'latar_belakang' => $request->latar_belakang,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            if (!$rka)
                throw new \Exception('create rba error');
                
            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
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

        $whereAkun = function ($query){
            $query->where('tipe', 5)
                ->where('kode_akun', '<', '5.1.2')
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 1)
                        ->where('jenis', 1);
                });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRka = function ($query) use($user, $id){
            $query->where('kode_rka', Rka::KODE_RKA_21)
                ->where('id', '<>', $id)
                ->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rka1 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka1->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            if (count($kodeUnitKerja) > 0) {
                $query->whereNotIn('kode', $kodeUnitKerja);
            }
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
            ['unitKerja', 'rincianAnggaran.akun', 'rincianSumberDana.akun']
        );

        $kodeAkunRka = $rka->rincianSumberDana->map(function ($item) {
            return $item->akun->kode_akun;
        })->toArray();

        return view('admin.rka.rka21.edit', compact('unitKerja', 'akun', 'rka', 'akunParent', 'kodeAkunRka'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $kode
     * @return \Illuminate\Http\Response
     */
    public function editPak($id)
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereAkun = function ($query){
            $query->where('tipe', 5)
                ->where('kode_akun', '<', '5.1.2')
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 1)
                        ->where('jenis', 1);
                });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');
        $this->akun->makeModel();

        $whereRka = function ($query) use($user, $id){
            $query->where('kode_rka', Rka::KODE_RKA_21)
                ->where('id', '<>', $id)
                ->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rka21 = $this->rka->get(['*'], $whereRka);
        $kodeUnitKerja = $rka21->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        $this->rka->makeModel();
        
        $rka = $this->rka->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianSumberDana']
        );

        $maxKodeAkun = $rka->rincianAnggaran->sortByDesc('akun_id')->first()->akun->kode_akun;
        $whereAkunParent = function ($query) use ($maxKodeAkun) {
            $query->where('tipe', 5)
                ->orWhere(function ($q) {
                    $q->where('tipe', 5)
                        ->where('kelompok', 1)
                        ->where('jenis', 1);
                })
                ->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        return view('admin.rka.rka21.pak.edit', compact('unitKerja', 'akun', 'rka', 'akunParent', 'maxKodeAkun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RKA21Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rka = $this->rka->find($id);
            if (!$rka){
                throw new \Exception('Rka not found');
            }

            $this->rka->update([
                'kode_rka' => Rka::KODE_RKA_21,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rka->id);
            $this->rincianSumberDana->deleteAll($rka->id);

            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
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
    public function updatePak(RKA21Request $request, $id)
     {
        try {
            DB::beginTransaction();
            $rka = $this->rka->find($id);
            if (!$rka){
                throw new \Exception('Rka not found');
            }

            $this->rka->update([
                'kode_rka' => Rka::KODE_RKA_21,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rka->id);
            $this->rincianSumberDana->deleteAll($rka->id);

            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rka->getAkunId($request->kode_rekening[$key]);
                $rkaRincianAnggaran = $this->rincianAnggaran->create([
                    'rka_id' => $rka->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => parse_format_number($request->tarif[$key]), 
                    'satuan_pak' => $request->satuan_pak[$key], 
                    'volume_pak' => $request->volume_pak[$key], 
                    'tarif_pak' => parse_format_number($request->tarif_pak[$key]), 
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
                     'nominal_pak' => parse_format_number($request->nominal_pak[$key]),
                ]);

                if (!$rkaRincianSumberDana)
                    throw new \Exception('create rka rincian sumber dana error');
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
