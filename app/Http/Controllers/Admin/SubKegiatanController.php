<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Organisasi\SubKegiatanRepository;
use App\Repositories\Organisasi\KegiatanRepository;
use App\Http\Requests\Organisasi\SubKegiatanRequest;

class SubKegiatanController extends Controller
{

    private $subKegiatan;
    private $kegiatan;

    public function __construct(
        SubKegiatanRepository $subKegiatan,
        KegiatanRepository $kegiatan
    ){
        $this->subKegiatan  = $subKegiatan;
        $this->kegiatan     = $kegiatan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subKegiatan    = $this->subKegiatan->get();
        $kegiatan       = $this->kegiatan->get();
        return view('admin.subKegiatan.index', compact('subKegiatan', 'kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubKegiatanRequest $request)
    {
        $subKegiatan    = $this->subKegiatan->create($request->all());
        return redirect()->back()->with(['success'  => $subKegiatan->namaSubKegiatan . 'Berhasil Disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
