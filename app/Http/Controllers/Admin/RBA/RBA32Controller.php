<?php

namespace App\Http\Controllers\Admin\RBA;

use App\Models\Rba;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RBA\RBA32Request;
use App\Repositories\RBA\RBARepository;
use App\Repositories\User\UserRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RBA\RBARincianAnggaranRepository;
use App\Repositories\RBA\RBARincianSumberDanaRepository;

class RBA32Controller extends Controller
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
     * @var UserRepository
     */
    private $user;

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
        UserRepository $user
    ) {
        $this->unitKerja = $unitKerja;
        $this->rba = $rba;
        $this->akun = $akun;
        $this->sumberDana = $sumberDana;
        $this->rincianAnggaran = $rincianAnggaran;
        $this->rincianSumberDana = $rincianSumberDana;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereRba = function ($query) use($user){
            $query->where('kode_rba', Rba::KODE_RBA_32);
            $query->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }

        };
        $rba = $this->rba->get(['*'], $whereRba, ['unitKerja', 'rincianSumberDana']);
        $rba->sum(function ($rba){
            $rba->total_nominal = $rba->rincianSumberDana->sum('nominal');
        });

        $rba = $rba->sortByDesc('created_at');

        return view('admin.rba.rba32.index', compact('rba'));
    }

    /**
     * create
     *
     * @param [String] $kodeUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        
        $whereAkun = function ($query){
            $query->where('tipe', 6)->where('kelompok', 2);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user){
            $query->where('kode_rba', Rba::KODE_RBA_32);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba31 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba31->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            $query->whereNotIn('kode', $kodeUnitKerja);
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);
        return view('admin.rba.rba32.create', compact('unitKerja', 'akun'));
    }

    /**
     * Store
     *
     * @return void
     */
    public function store(RBA32Request $request)
    {      
        try {
            DB::beginTransaction();
            $rba = $this->rba->create([
                'kode_rba' => Rba::KODE_RBA_32,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'latar_belakang' => $request->latar_belakang,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            if (!$rba)
                throw new \Exception('create rba error');
                
            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => $request->tarif[$key], 
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
                     'nominal' => $request->nominal[$key],
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
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
            $query->where('tipe', 6)->where('kelompok', 2);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user){
            $query->where('kode_rba', Rba::KODE_RBA_31);
            
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba31 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba31->pluck('kode_unit_kerja');

        $unitKerja = $this->unitKerja->get();

        $akunTipe = 4;
        $whereAkunParent = function ($query) use ($akunTipe) {
            $query->where('tipe', $akunTipe);
            $query->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        $rba = $this->rba->findBy(
            'id',
            '=',
            $id,
            ['*'],
            ['unitKerja', 'rincianAnggaran.akun', 'rincianSumberDana']
        );

        return view('admin.rba.rba32.edit', compact('unitKerja', 'akun', 'rba', 'akunParent'));
    }

    /**
     * Edit PAK.
     *
     * @param string $kode
     * @return void
     */
    public function editPak($id)
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        
        $whereAkun = function ($query){
            $query->where('tipe', 6)->where('kelompok', 2);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user){
            $query->where('kode_rba', Rba::KODE_RBA_32);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba31 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba31->pluck('kode_unit_kerja');

        $whereUnitKerja = function ($query) use ($kodeUnitKerja, $user){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        $akunTipe = 4;
        $whereAkunParent = function ($query) use ($akunTipe) {
            $query->where('tipe', $akunTipe);
            $query->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        $rba = $this->rba->getRbaUpdate($id, auth()->user()->status, Rba::KODE_RBA_32);

        return view('admin.rba.rba32.pak.edit', compact('unitKerja', 'akun', 'rba', 'akunParent'));
    }

    /**
     * 
     */
    public function update(RBA32Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba){
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_32,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'latar_belakang' => $request->latar_belakang,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rba->id);
            $this->rincianSumberDana->deleteAll($rba->id);

            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => $request->tarif[$key], 
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
                     'nominal' => $request->nominal[$key],
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
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
     * Update PAK RBA 3.2
     *
     * @param RBA1Request $request
     * @param [type] $id
     * @return void
     */
    public function updatePak(RBA32Request $request, $id)
    {
         try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba){
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_32,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
                'tipe' => auth()->user()->status,
                'latar_belakang' => $request->latar_belakang,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ], $id);

            $this->rincianAnggaran->deleteAll($rba->id);
            $this->rincianSumberDana->deleteAll($rba->id);

            foreach($request->kode_rekening as $key => $data){
                $akun = $this->rba->getAkunId($request->kode_rekening[$key]);
                $rbaRincianAnggaran = $this->rincianAnggaran->create([
                    'rba_id' => $rba->id,
                    'akun_id' => $akun->id,
                    'uraian' => $request->uraian[$key],
                    'satuan' => $request->satuan[$key], 
                    'volume' => $request->volume[$key], 
                    'tarif' => $request->tarif[$key], 
                    'satuan_pak' => $request->satuan_pak[$key], 
                    'volume_pak' => $request->volume_pak[$key], 
                    'tarif_pak' => $request->tarif_pak[$key], 
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
                     'nominal' => $request->nominal[$key],
                ]);

                if (!$rbaRincianSumberDana)
                    throw new \Exception('create rba rincian sumber dana error');
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
}
