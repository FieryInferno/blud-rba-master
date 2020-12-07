<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\AkunRepository;
use App\Http\Requests\DataDasar\MapAkunRequest;
use App\Repositories\DataDasar\MapAkunRepository;

class MapAkunController extends Controller
{
     /**
     * Bidang repository.
     * 
     * @var AkunRepository
     */
    private $akun;

     /**
     * Map akun repository.
     * 
     * @var MapAkunRepository
     */
    private $mapAkun;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        MapAkunRepository $mapAkun
        )
    {
        $this->akun = $akun;
        $this->mapAkun = $mapAkun;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = function ($query) {
            $query->where('is_parent', false);
        };
        $akun = $this->akun->get(['*'], $where);
        $mapAkun = $this->mapAkun->get(['*'], null, ['akun', 'map']);
        return view('admin.map_akun.index', compact('akun', 'mapAkun')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MapAkunRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapAkunRequest $request)
    {
        $mapAkun = $this->mapAkun->create([
            'kode_akun' => $request->kode_akun,
            'kode_map_akun' => $request->kode_pemetaan
        ]);
        return redirect()->back()
                ->with(['success' => 'Pemetaan akun berhasil disimpan']);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param MapAkunRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(MapAkunRequest $request)
    {
        $mapAkun = $this->mapAkun->update([
            'kode_akun' => $request->kode_akun,
            'kode_map_akun' => $request->kode_pemetaan,
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
        $this->mapAkun->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
