<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rka;
use App\Models\Rba;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\DataDasar\MapKegiatanRequest;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\DataDasar\MapKegiatanRepository;
use App\Repositories\RKA\RKARepository;

class MapKegiatanController extends Controller
{
    /**
     * Map kegiatan repository.
     * 
     * @var MapKegiatanRepository
     */
    private $mapKegiatan;

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
    private $unitKerja;

    /**
     * RBA repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * RKA repository.
     * 
     * @var RKARepository
     */
    private $rka;

    /**
     * Constructor.
     */
    public function __construct(
        UnitKerjaRepository $unitKerja,
        KegiatanRepository $kegiatan,
        MapKegiatanRepository $mapKegiatan,
        RBARepository $rba,
        RKARepository $rka
    ) {
        $this->unitKerja = $unitKerja;
        $this->kegiatan = $kegiatan;
        $this->mapKegiatan = $mapKegiatan;
        $this->rba = $rba;
        $this->rka = $rka;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unitKerja = $this->unitKerja->get();
        $kegiatan = $this->kegiatan->get();
        $mapKegiatan = $this->mapKegiatan->get(['*'], null, ['blud', 'apbd']);
        return view('admin.map_kegiatan.index', compact('unitKerja', 'kegiatan', 'mapKegiatan')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MapKegiatanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapKegiatanRequest $request)
    {
        $mapKegiatan = $this->mapKegiatan->create([
            'kode_unit_kerja' => $request->kode_unit_kerja,
            'kegiatan_id_blud' => $request->kegiatan_id_blud,
            'kegiatan_id_apbd' => $request->kegiatan_id_apbd,
        ]);
        return redirect()->back()
                ->with(['success' => 'Pemetaan akun berhasil disimpan']);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param MapKegiatanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(MapKegiatanRequest $request)
    {
        $mapKegiatan = $this->mapKegiatan->update([
            'kode_unit_kerja' => $request->kode_unit_kerja,
            'kegiatan_id_blud' => $request->kegiatan_id_blud,
            'kegiatan_id_apbd' => $request->kegiatan_id_apbd,
        ], $request->id);
        return redirect()->back()
                ->with(['success' => 'Pemetaan akun berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rba = $this->rba->findBy('map_kegiatan_id', '=', $request->id);
        if ($rba) {
            return redirect()->back()
                ->with(['error' => 'Pemetaan kegiatan tidak dapat dihapus karena digunakan pada RBA']);
        }

        $rka = $this->rka->findBy('map_kegiatan_id', '=', $request->id);
        if ($rka) {
            return redirect()->back()
                ->with(['error' => 'Pemetaan kegiatan tidak dapat dihapus karena digunakan pada RKA']);
        }

        $this->mapKegiatan->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    public function getData(Request $request)
    {
        try {
            $target = [];
            if ($request->kode == 'rba') {
                $whereRba = function ($query) use ($request) {
                    $query->where('kode_rba', Rba::KODE_RBA_221)
                        ->where('kode_unit_kerja', $request->kode_unit_kerja)
                        ->where('tipe', auth()->user()->status);

                    if ($request->id) {
                        $query->where('id', '<>', $request->id);
                    }
                };
                $target = $this->rba->get(['*'], $whereRba);
            } else if ($request->kode =='rka') {
                $whereRka = function ($query) use ($request) {
                    $query->where('kode_rka', Rka::KODE_RKA_221)
                        ->where('kode_unit_kerja', $request->kode_unit_kerja)
                        ->where('tipe', auth()->user()->status);

                    if ($request->id) {
                        $query->where('id', '<>', $request->id);
                    }
                };
                $target = $this->rka->get(['*'], $whereRka);
            }
            
            $exceptKegiatan = $target->pluck('map_kegiatan_id')->toArray();
            $where = function ($query) use($request, $exceptKegiatan){
                $query->where('kode_unit_kerja', $request->kode_unit_kerja);
                if (! $request->tipe){
                    $query->whereNotIn('id', $exceptKegiatan);
                }
            };
            $kegiatan = $this->mapKegiatan->get(['*'], $where, ['blud']);

            return response()->json([
                'status_code' => 200,
                'data' => $kegiatan,
                'total_data' => $kegiatan->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }
}
