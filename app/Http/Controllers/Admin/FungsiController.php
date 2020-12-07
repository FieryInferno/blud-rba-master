<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\FungsiRequest;
use App\Repositories\Organisasi\FungsiRepository;
use App\Http\Requests\Organisasi\FungsiEditRequest;

class FungsiController extends Controller
{
    /**
     * Fungsi repository.
     * 
     * @var FungsiRepository
     */
    private $fungsi;

    /**
     * Constructor.
     */
    public function __construct(FungsiRepository $fungsi)
    {
        $this->fungsi = $fungsi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fungsi = $this->fungsi->get();
        return view('admin.fungsi.index', compact('fungsi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FungsiRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FungsiRequest $request)
    {
        $fungsi = $this->fungsi->create($request->only(['kode', 'nama_fungsi']));
        return redirect()->back()
                ->with(['success' => "{$fungsi->nama_fungsi} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FungsiEditRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(FungsiEditRequest $request)
    {
        $this->fungsi->update($request->only('nama_fungsi'), $request->id);
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
        $this->fungsi->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
