<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rba;
use App\Models\Rka;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalinAnggaran\SalinAnggaranRbaRequest;
use App\Http\Requests\SalinAnggaran\SalinAnggaranRequest;
use App\Http\Requests\SalinAnggaran\SalinAnggaranRkaRequest;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RBA\RBARepository;
use App\Repositories\RKA\RKARepository;
use App\Repositories\StatusAnggaran\StatusAnggaranRepository;
use App\Repositories\User\UserRepository;

class SalinAnggaranController extends Controller
{
    /**
     * Rba repository.
     * 
     * @var RBARepository
     */
    private $rba;
    
    /**
     * Rka repository.
     * 
     * @var RKARepository
     */
    private $rka;

    /**
     * Unit kerja repository.
     * 
     * @var UserRepository
     */
    private $user;

    /**
     * Status anggaran repository
     * 
     * @var StatusAnggaranRepository
     */
    private $statusAnggaran;

    /**
     * Unit kerja repository
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

     /**
     * Construct.
     */
    public function __construct(
        RBARepository $rba,
        RKARepository $rka,
        UserRepository $user,
        StatusAnggaranRepository $statusAnggaran,
        UnitKerjaRepository $unitKerja
    ) {
        $this->rba = $rba;
        $this->user = $user;
        $this->rka = $rka;
        $this->statusAnggaran = $statusAnggaran;
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rba(Request $request)
    {
        $unitKerja = $this->unitKerja->get();
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        if ($user->role->role_name == Role::ROLE_PUSKESMAS){
            $rba = $this->rba->getRbaMurni($request, $user->unitKerja->kode);
        }else {
            $rba = $this->rba->getRbaMurni($request);
        }

        $where = function ($query) {
            $query->where('status_perubahan', Rba::STATUS_PERUBAHAN_PERUBAHAN);
        };
        $statusAnggaran = $this->statusAnggaran->get(['*'], $where);
        return view('admin.salin-anggaran.rba', compact('rba', 'statusAnggaran', 'unitKerja'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rka(Request $request)
    {
        $unitKerja = $this->unitKerja->get();
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        if ($user->role->role_name == Role::ROLE_PUSKESMAS) {
            $rka = $this->rka->getRkaMurni($request, $user->unitKerja->kode);
        } else {
            $rka = $this->rka->getRkaMurni($request);
        }

        $where = function ($query) {
            $query->where('status_perubahan', Rba::STATUS_PERUBAHAN_PERUBAHAN);
        };
        $statusAnggaran = $this->statusAnggaran->get(['*'], $where);

        return view('admin.salin-anggaran.rka', compact('rka', 'statusAnggaran', 'unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rbaStore(SalinAnggaranRbaRequest $request)
    {
        try {
            DB::beginTransaction();

            $rbaSelected = $request->only(['rba_selected'])['rba_selected'];

            foreach ($request->status_anggaran as $key => $req){
                if (! is_null($request->status_anggaran[$key])){
                    if (in_array($request->rba[$key],  $rbaSelected)){
                        $rba = $this->rba->findBy('id', '=', $request->rba[$key], ['*'], ['rincianAnggaran', 'rincianSumberDana', 'statusAnggaran']);
                        $this->rba->makeModel();

                        $newRba = $this->rba->create([
                            'kode_rba' => $rba->getOriginal('kode_rba'),
                            'kode_opd' => $rba->kode_opd,
                            'kode_unit_kerja' => $rba->kode_unit_kerja,
                            'pejabat_id' => $rba->pejabat_id,
                            'rba_murni_id' => $rba->id,
                            'map_kegiatan_id' => $rba->map_kegiatan_id,
                            'kode_kegiatan' => $rba->kode_kegiatan,
                            'kelompok_sasaran' => $rba->kelompok_sasaran,
                            'latar_belakang' => $rba->latar_belakang,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'status_anggaran_id' => $request->status_anggaran[$key],
                        ]);

                        $volume = 'volume';
                        $tarif = 'tarif';
                        $satuan = 'satuan';
                        $nominal = 'nominal';
                        if ($rba->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN){
                            $volume = 'volume_pak';
                            $tarif = 'tarif_pak';
                            $satuan = 'satuan_pak';
                            $nominal = 'nominal_pak';
                        }

                        $rincian = $rba->rincianAnggaran->map(function ($element) use($volume, $tarif, $satuan) {
                            $element->volume = $element->{$volume};
                            $element->tarif = $element->{$tarif};
                            $element->satuan = $element->{$satuan};
                            $element->volume_pak = $element->{$volume};
                            $element->tarif_pak = $element->{$tarif};
                            $element->satuan_pak = $element->{$satuan};
                            $el = $element->toArray();
                            unset($el['id']);
                            return $el;
                        });

                        $rincianRba = $newRba->rincianAnggaran()->createMany($rincian->toArray());

                        if (! $rincianRba){
                            throw new Exception("Error Processing Request create rincian rba");
                        }

                        $sumberDana = $rba->rincianSumberDana->map(function ($element) use($nominal){
                            $el = $element->toArray();
                            $el['nominal_pak'] = $el[$nominal];
                            $el['nominal'] = $el[$nominal];
                            unset($el['id']);
                            return $el;
                        });

                        $rincianDanaRba = $newRba->rincianSumberDana()->createMany($sumberDana->toArray());

                        if (!$rincianDanaRba) {
                            throw new Exception("Error Processing Request create rincian sumber dana rba");
                        }

                        if ($rba->getOriginal('kode_rba') == Rba::KODE_RBA_221) {
                            $indikatorKerja = $rba->indikatorKerja->map(function ($element) {
                                $el = $element->toArray();
                                unset($el['id']);
                                return $el;
                            });

                            $indikatorKerjaRba = $newRba->indikatorKerja()->createMany($indikatorKerja->toArray());
                            if (!$indikatorKerjaRba) {
                                throw new Exception("Error Processing Request create indikator kerja");
                            }
                        }
                    }
                }   
            }

            DB::commit();
            return redirect()->back()
                ->with(['success' => 'Data berhasil di salin']);

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()
                ->with(['success' => $e->getMessage()]);
        }
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rkaStore(SalinAnggaranRkaRequest $request)
    {
        try {
            DB::beginTransaction();

            $rkaSelected = $request->only(['rka_selected'])['rka_selected'];

            foreach ($request->status_anggaran as $key => $req) {
                if (!is_null($request->status_anggaran[$key])) {
                    if (in_array($request->rka[$key],  $rkaSelected)) {
                        $rka = $this->rka->findBy('id', '=', $request->rka[$key], ['*'], ['rincianAnggaran', 'rincianSumberDana', 'statusAnggaran']);
                        $this->rka->makeModel();

                        $newRka = $this->rka->create([
                            'kode_rka' => $rka->getOriginal('kode_rka'),
                            'kode_opd' => $rka->kode_opd,
                            'kode_unit_kerja' => $rka->kode_unit_kerja,
                            'pejabat_id' => $rka->pejabat_id,
                            'rka_murni_id' => $rka->id,
                            'map_kegiatan_id' => $rka->map_kegiatan_id,
                            'kode_kegiatan' => $rka->kode_kegiatan,
                            'kelompok_sasaran' => $rka->kelompok_sasaran,
                            'latar_belakang' => $rka->latar_belakang,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'status_anggaran_id' => $request->status_anggaran[$key],
                        ]);

                        $volume = 'volume';
                        $tarif = 'tarif';
                        $satuan = 'satuan';
                        $nominal = 'nominal';
                        if ($rka->statusAnggaran->status_perubahan == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                            $volume = 'volume_pak';
                            $tarif = 'tarif_pak';
                            $satuan = 'satuan_pak';
                            $nominal = 'nominal_pak';
                        }

                        $rincian = $rka->rincianAnggaran->map(function ($element) use ($volume, $tarif, $satuan) {
                            $element->volume = $element->{$volume};
                            $element->tarif = $element->{$tarif};
                            $element->satuan = $element->{$satuan};
                            $element->volume_pak = $element->{$volume};
                            $element->tarif_pak = $element->{$tarif};
                            $element->satuan_pak = $element->{$satuan};
                            $el = $element->toArray();
                            unset($el['id']);
                            return $el;
                        });

                        $rincianRka = $newRka->rincianAnggaran()->createMany($rincian->toArray());

                        if (!$rincianRka) {
                            throw new Exception("Error Processing Request create rincian rba");
                        }

                        $sumberDana = $rka->rincianSumberDana->map(function ($element) use ($nominal) {
                            $el = $element->toArray();
                            $el['nominal_pak'] = $el[$nominal];
                            $el['nominal'] = $el[$nominal];
                            unset($el['id']);
                            return $el;
                        });

                        $rincianDanaRba = $newRka->rincianSumberDana()->createMany($sumberDana->toArray());

                        if (!$rincianDanaRba) {
                            throw new Exception("Error Processing Request create rincian sumber dana rba");
                        }

                        if ($rka->getOriginal('kode_rka') == Rka::KODE_RKA_221) {
                            $indikatorKerja = $rka->indikatorKerja->map(function ($element) {
                                $el = $element->toArray();
                                unset($el['id']);
                                return $el;
                            });

                            $indikatorKerjaRba = $newRka->indikatorKerja()->createMany($indikatorKerja->toArray());
                            if (!$indikatorKerjaRba) {
                                throw new Exception("Error Processing Request create indikator kerja");
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()
                ->with(['success' => 'Data berhasil di salin']);

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()
                ->with(['success' => 'Data gagal di salin']);
        }
    }


}
