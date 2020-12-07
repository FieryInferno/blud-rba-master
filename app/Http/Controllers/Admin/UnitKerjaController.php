<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\UnitKerjaRequest;
use App\Repositories\Organisasi\UnitKerjaRepository;

class UnitKerjaController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Constructor.
     */
    public function __construct(UnitKerjaRepository $unitKerja)
    {
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unitKerja = $this->unitKerja->get();
        return view('admin.unit_kerja.index', compact('unitKerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitKerjaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitKerjaRequest $request)
    {
        $unitKerja = $this->unitKerja->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$unitKerja->nama_unit} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UnitKerjaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UnitKerjaRequest $request)
    {
        $data = $request->only(['kode', 'kode_opd', 'nama_unit']);
        $this->unitKerja->update($data, $request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->unitKerja->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
