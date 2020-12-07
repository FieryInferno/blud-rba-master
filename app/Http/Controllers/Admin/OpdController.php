<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\OpdRequest;
use App\Repositories\Organisasi\OpdRepository;
use App\Repositories\DataDasar\JabatanRepository;

class OpdController extends Controller
{
    /**
     * Opd repository.
     * 
     * @var OpdRepository
     */
    private $opd;

    /**
     * Jabatan repository.
     * 
     * @var JabatanRepository
     */
    private $jabatan;

    /**
     * Constructor.
     */
    public function __construct(OpdRepository $opd, JabatanRepository $jabatan)
    {
        $this->opd = $opd;
        $this->jabatan = $jabatan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opd = $this->opd->get();
        $jabatan = $this->jabatan->get();
        return view('admin.opd.index', compact('opd', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OpdRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpdRequest $request)
    {
        $opd = $this->opd->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$opd->nama_pejabat} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OpdRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(OpdRequest $request)
    {
        $data = $request->only(['kode', 'nama_pejabat', 'nip', 'jabatan_id', 'status']);
        $this->opd->update($data, $request->id);
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
        $this->opd->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
