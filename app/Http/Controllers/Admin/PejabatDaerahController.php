<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\JabatanRepository;
use App\Http\Requests\DataDasar\PejabatDaerahRequest;
use App\Repositories\DataDasar\PejabatDaerahRepository;


class PejabatDaerahController extends Controller
{
     /**
     * Urusan repository.
     * 
     * @var PejabatDaerahController
     */
    private $pejabat;

     /**
     * Urusan repository.
     * 
     * @var PejabatDaerahController
     */
    private $jabatan;

    /**
     * Constructor.
     */
    public function __construct(
        PejabatDaerahRepository $pejabat,
        JabatanRepository $jabatan
        )
    {
        $this->pejabat = $pejabat;
        $this->jabatan = $jabatan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = $this->jabatan->get();
        $pejabat = $this->pejabat->get(['*'], null, 'jabatan');
        return view('admin.pejabat.index', compact('pejabat', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PejabatDaerahRequest $request)
    {
        $pejabat = $this->pejabat->create($request->only(['nama', 'nip', 'jabatan_id']));
        return redirect()->back()
                ->with(['success' => "{$pejabat->nama} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PejabatDaerahRequest $request)
    {
        $this->pejabat->update($request->only(['nama', 'nip', 'jabatan_id', 'status']), $request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil diperbarui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->pejabat->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
