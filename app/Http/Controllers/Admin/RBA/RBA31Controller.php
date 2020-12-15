<?php

namespace App\Http\Controllers\Admin\RBA;

use App\Models\Rba;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RBA\RBA31Request;
use App\Repositories\RBA\RBARepository;
use App\Repositories\User\UserRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\SumberDanaRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RBA\RBARincianAnggaranRepository;
use App\Repositories\RBA\RBARincianSumberDanaRepository;

class RBA31Controller extends Controller
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

        // $this->middleware('permission:buat RBA')->only('create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user       = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);
        $unitKerja  = $this->unitKerja->get();
        $whereRba   = function ($query) use ($user, $request) {
            $query->where('kode_rba', Rba::KODE_RBA_31);
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
        $rba = $this->rba->get(['*'], $whereRba, ['unitKerja', 'rincianSumberDana']);
        $rba->sum(function ($rba){
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
        });

        $rba = $rba->sortByDesc('created_at');

        $totalAllRba1Murni = $rba->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal');
        });

        $totalAllRba1Pak = $rba->sum(function ($item) {
            return  $item->rincianSumberDana->sum('nominal_pak');
        });

        $totalAllRba = [
            'murni' => $totalAllRba1Murni,
            'pak' => $totalAllRba1Pak
        ];

        return view('admin.rba.rba31.index', compact('rba', 'unitKerja', 'totalAllRba'));
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
        
        $whereAkun = function ($query) {
            $query->where('tipe', 6)
                ->orWhere(function ($q) {
                $q->where('tipe', 6)
                    ->where('kelompok', 1);
            });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) {
            $query->where('kode_rba', Rba::KODE_RBA_31);
        };

        $rba31 = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba31->pluck('kode_unit_kerja')->toArray();

        $whereUnitKerja = function ($query) use ($user, $kodeUnitKerja){
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode', $user->unitKerja->kode);
            }
            $query->whereNotIn('kode', $kodeUnitKerja);
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);
        return view('admin.rba.rba31.create', compact('unitKerja', 'akun'));
    }

    /**
     * Store
     *
     * @return void
     */
    public function store(RBA31Request $request)
    {      
        try {
            DB::beginTransaction();
            $rba = $this->rba->create([
                'kode_rba'              => Rba::KODE_RBA_31,
                'kode_opd'              => $request->kode_opd,
                'kode_unit_kerja'       => $request->unit_kerja,
                'pejabat_id'            => $request->pejabat_unit,
                'latar_belakang'        => $request->latar_belakang,
                'created_by'            => auth()->user()->id,
                'updated_by'            => auth()->user()->id,
                'status_anggaran_id'    =>auth()->user()->statusAnggaran->id
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

        $whereAkun = function ($query) {
            $query->where('tipe', 6)
                ->orWhere(function ($q) {
                $q->where('tipe', 6)
                    ->where('kelompok', 1);
            });
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user, $id){
            $query->where('kode_rba', Rba::KODE_RBA_31)
                ->where('id', '<>', $id)
                ->where('status_anggaran_id', auth()->user()->statusAnggaran->id);
            
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
            if (count($kodeUnitKerja) > 0) {
                $query->whereNotIn('kode', $kodeUnitKerja);
            }
        };
        
        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        $akunTipe = 6;
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
            ['unitKerja', 'rincianAnggaran.akun', 'rincianSumberDana']
        );

        $kodeAkunRba = $rba->rincianSumberDana->map(function ($item) {
            return $item->akun->kode_akun;
        })->toArray();

        $oldSumberDana = [];
        foreach ($rba->rincianSumberDana as $sumberDana) {
            $oldSumberDana[] = [
                'kode_akun' => $sumberDana->akun->kode_akun,
                'sumber_dana' => $sumberDana->sumber_dana_id
            ];
        }
        $oldSumberDana = json_encode($oldSumberDana);

        return view('admin.rba.rba31.edit', compact('unitKerja', 'akun', 'rba', 'akunParent', 'kodeAkunRba', 'oldSumberDana'));
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
            $query->where('tipe', 6)->where('kelompok', 1);
        };
        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');

        $whereRba = function ($query) use($user, $id){
            $query->where('kode_rba', Rba::KODE_RBA_31)
                ->where('id', '<>', $id)
                ->where('status_anggaran_id', auth()->user()->statusAnggaran->id);

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

        $akunTipe = 6;
        $whereAkunParent = function ($query) use ($akunTipe) {
            $query->where('tipe', $akunTipe)
                ->where('is_parent', true);
        };
        $akunParent = $this->akun->get(['*'], $whereAkunParent);

        $this->rba->makeModel();

        $rba = $this->rba->getRbaUpdate($id, auth()->user()->statusAnggaran->id, Rba::KODE_RBA_31);

        $kodeAkunRba = $rba->rincianSumberDana->map(function ($item) {
            return $item->akun->kode_akun;
        })->toArray();

        $oldSumberDana = [];
        foreach ($rba->rincianSumberDana as $sumberDana) {
            $oldSumberDana[] = [
                'kode_akun' => $sumberDana->akun->kode_akun,
                'sumber_dana' => $sumberDana->sumber_dana_id
            ];
        }
        $oldSumberDana = json_encode($oldSumberDana);

        return view('admin.rba.rba31.pak.edit', compact('unitKerja', 'akun', 'rba', 'akunParent', 'oldSumberDana', 'kodeAkunRba'));
    }

    /**
     * 
     */
    public function update(RBA31Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba){
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_31,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
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
     * Update PAK RBA 3.1
     *
     * @param RBA1Request $request
     * @param [type] $id
     * @return void
     */
    public function updatePak(RBA31Request $request, $id)
    {
         try {
            DB::beginTransaction();
            $rba = $this->rba->find($id);
            if (!$rba){
                throw new \Exception('Rba not found');
            }

            $this->rba->update([
                'kode_rba' => Rba::KODE_RBA_31,
                'kode_opd' => $request->kode_opd,
                'kode_unit_kerja' => $request->unit_kerja,
                'pejabat_id' => $request->pejabat_unit,
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
                    'tarif' => parse_format_number($request->tarif[$key]), 
                    'satuan_pak' => $request->satuan_pak[$key], 
                    'volume_pak' => $request->volume_pak[$key], 
                    'tarif_pak' => parse_format_number($request->tarif_pak[$key]), 
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
                     'nominal_pak' => parse_format_number($request->nominal_pak[$key]),
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
