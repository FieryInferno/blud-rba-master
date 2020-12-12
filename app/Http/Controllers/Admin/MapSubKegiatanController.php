<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\MapSubKegiatanRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Organisasi\SubKegiatanRepository;
use App\Http\Requests\Organisasi\MapSubKegiatanRequest;

class MapSubKegiatanController extends Controller
{

    private $mapSubKegiatan;
    private $unitKerja;
    private $subKegiatan;

    public function __construct(
        MapSubKegiatanRepository $mapSubKegiatan,
        UnitKerjaRepository $unitKerja,
        SubKegiatanRepository $subKegiatan
    ){
        $this->mapSubKegiatan   = $mapSubKegiatan;
        $this->unitKerja        = $unitKerja;
        $this->subKegiatan      = $subKegiatan;
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
}
