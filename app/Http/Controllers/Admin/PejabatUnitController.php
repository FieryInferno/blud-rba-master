<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\PejabatUnitRequest;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\Organisasi\PejabatUnitRepository;
use App\Repositories\Organisasi\JabatanPejabatUnitRepository;
use App\Repositories\RBA\RBARepository;
use App\Repositories\RKA\RKARepository;

class PejabatUnitController extends Controller
{
    /**
     * Pejabat unit repository.
     *
     * @var PejabatUnitRepository
     */
    private $pejabatUnit;

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Jabatan repository.
     *
     * @var JabatanPejabatUnitRepository
     */
    private $jabatan;

    /**
     * Jabatan repository.
     *
     * @var RbaRepository
     */
    private $rba;

    /**
     * Jabatan repository.
     *
     * @var RkaRepository
     */
    private $rka;

    /**
     * Constructor.
     */
    public function __construct(
        PejabatUnitRepository $pejabatUnit,
        UnitKerjaRepository $unitKerja,
        JabatanPejabatUnitRepository $jabatan,
        RBARepository $rba,
        RKARepository $rka
    ) {
        $this->pejabatUnit = $pejabatUnit;
        $this->unitKerja = $unitKerja;
        $this->jabatan = $jabatan;
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
        $unitKerja = $this->unitKerja->get(['*'], null, ['pejabat']);
        $jabatan = $this->jabatan->get();
        return view('admin.pejabat_unit.index', compact('jabatan', 'unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PejabatUnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PejabatUnitRequest $request)
    {
        $pejabat = $this->pejabatUnit->create([
            'nama_pejabat' => $request->nama_pejabat,
            'nip' => $request->nip,
            'jabatan_id' => $request->jabatan_id,
            'kode_unit_kerja' => $request->unit_kerja
        ]);
        return redirect()->back()
                ->with(['success' => "{$pejabat->nama_pejabat} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PejabatUnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PejabatUnitRequest $request)
    {
        $pejabat = $this->pejabatUnit->find($request->id);
        $pejabat->update([
            'nama_pejabat' => $request->nama_pejabat,
            'nip' => $request->nip,
            'jabatan_id' => $request->jabatan_id,
            'kode_unit_kerja' => $request->unit_kerja,
            'status' => $request->status
        ]);
        return redirect()->back()
                ->with(['success' => "{$pejabat->nama_pejabat} berhasil diperbarui di unit kerja {$pejabat->unit->nama_unit}"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rba = $this->rba->findBy('pejabat_id', '=', $request->id);

        if ($rba){
            return redirect()->back()
                ->with(['error' => 'Pejabat tidak dapat dihapus karena telah digunakan di rba ']);
        }

        $rka = $this->rka->findBy('pejabat_id', '=', $request->id);

        if ($rka) {
            return redirect()->back()
                ->with(['error' => 'Pejabat tidak dapat dihapus karena telah digunakan di rka ']);
        }

        $this->pejabatUnit->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * GetData by request ajax
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        try {
            
            $where = function ($query) use($request){
                $query->where('kode_unit_kerja', $request->kode_unit_kerja);
            };
            $pejabatUnit = $this->pejabatUnit->get(['*'], $where);
            return response()->json([
                'status_code' => 200,
                'data' => $pejabatUnit,
                'total_data' => $pejabatUnit->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }
}
