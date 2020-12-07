<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\BidangRequest;
use App\Repositories\Organisasi\BidangRepository;
use App\Repositories\Organisasi\FungsiRepository;
use App\Repositories\Organisasi\UrusanRepository;

class BidangController extends Controller
{
    /**
     * Bidang repository.
     * 
     * @var BidangRepository
     */
    private $bidang;

    /**
     * Fungsi repository.
     * 
     * @var FungsiRepository
     */
    private $fungsi;

    /**
     * Urusan repository.
     * 
     * @var UrusanRepository
     */
    private $urusan;

    /**
     * Constructor.
     */
    public function __construct(
        BidangRepository $bidang,
        FungsiRepository $fungsi,
        UrusanRepository $urusan
    ) {
        $this->bidang = $bidang;
        $this->fungsi = $fungsi;
        $this->urusan = $urusan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bidang = $this->bidang->get();
        $fungsi = $this->fungsi->get();
        $urusan = $this->urusan->get();
        return view('admin.bidang.index', compact('bidang', 'fungsi', 'urusan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BidangRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BidangRequest $request)
    {
        $bidang = $this->bidang->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$bidang->nama_bidang} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BidangRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(BidangRequest $request)
    {
        $data = $request->only(['kode_fungsi', 'kode_urusan', 'kode', 'nama_bidang']);
        $this->bidang->update($data, $request->id);
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
        $this->bidang->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
