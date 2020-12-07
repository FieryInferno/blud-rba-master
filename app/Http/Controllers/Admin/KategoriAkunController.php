<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\KategoriAkunRequest;
use App\Repositories\DataDasar\KategoriAkunRepository;

class KategoriAkunController extends Controller
{
    /**
     * Urusan repository.
     * 
     * @var KategoriAkunController
     */
    private $kategoriAkun;

    /**
     * Constructor.
     */
    public function __construct(
        KategoriAKunRepository $kategoriAkun
        )
    {
        $this->kategoriAkun = $kategoriAkun;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saldoNormal = ['Debet', 'Kredit'];
        $kategoriAkun = $this->kategoriAkun->get();
        return view('admin.kategori-akun.index', compact('kategoriAkun', 'saldoNormal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriAkunRequest $request)
    {
        $kategoriAkun = $this->kategoriAkun->create($request->only(['kode', 'nama_akun', 'saldo_normal']));
        return redirect()->back()
                ->with(['success' => "{$kategoriAkun->nama_akun} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KategoriAkunRequest $request)
    {
        $kategoriAkun = $this->kategoriAkun->update($request->only(['kode', 'nama_akun', 'saldo_normal']), $request->id);
        return redirect()->back()
                ->with(['success' => "Data berhasil diperbaharui"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->kategoriAkun->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
