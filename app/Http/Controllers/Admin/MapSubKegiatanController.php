<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\MapSubKegiatanRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Organisasi\SubKegiatanRepository;
use App\Repositories\RKA\RKARepository;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\Organisasi\MapSubKegiatanRequest;
use App\Models\Rka;
use App\Models\Rba;

class MapSubKegiatanController extends Controller
{

    private $mapSubKegiatan;
    private $unitKerja;
    private $subKegiatan;
    private $rba;
    private $rka;

    public function __construct(
        MapSubKegiatanRepository $mapSubKegiatan,
        UnitKerjaRepository $unitKerja,
        SubKegiatanRepository $subKegiatan,
        RBARepository $rba,
        RKARepository $rka
    ){
        $this->mapSubKegiatan   = $mapSubKegiatan;
        $this->unitKerja        = $unitKerja;
        $this->subKegiatan      = $subKegiatan;
        $this->rba              = $rba;
        $this->rka              = $rka;
    }

    public function index()
    {
        $mapSubKegiatan = $this->mapSubKegiatan->get();
        $unitKerja      = $this->unitKerja->get();
        $subKegiatan    = $this->subKegiatan->get();
        return view('admin.mapSubKegiatan.index', compact('mapSubKegiatan', 'unitKerja', 'subKegiatan'));
    }

    public function store(MapSubKegiatanRequest $request)
    {
        $this->mapSubKegiatan->create([
            'kodeUnitKerja'         => $request->kodeUnitKerja,
            'kodeSubKegiatanBlud'   => $request->kodeSubKegiatanBlud,
            'kodeSubKegiatanApbd'   => $request->kodeSubKegiatanApbd
        ]);
        return redirect()->back()->with([
            'success'   => 'Pemetaan Sub Kegiatan Berhasil Disimpan'
        ]);
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
            $where          = function ($query) use($request, $exceptKegiatan){
                $query->where('kodeUnitKerja', $request->kode_unit_kerja);
                if (! $request->tipe){
                    $query->whereNotIn('id', $exceptKegiatan);
                }
            };
            $mapSubKegiatan = $this->mapSubKegiatan->get(['*'], $where, ['subKegiatanBlud']);

            return response()->json([
                'status_code'   => 200,
                'data'          => $mapSubKegiatan,
                'total_data'    => $mapSubKegiatan->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }
}
