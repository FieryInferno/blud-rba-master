<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DataDasar\AkunRepository;
use App\Http\Requests\DataDasar\SumberDanaRequest;
use App\Repositories\DataDasar\SumberDanaRepository;

class SumberDanaController extends Controller
{
     /**
     * Program repository.
     * 
     * @var SumberDanaRepository
     */
    private $sumberDana;

     /**
     * Program repository.
     * 
     * @var AkunRepository
     */
    private $akun;

     /**
     * Constructor.
     */
    public function __construct(
        SumberDanaRepository $sumberDana,
        AkunRepository $akun
        )
    {
        $this->sumberDana = $sumberDana;
        $this->akun = $akun;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $where = function ($query) {
        //     $query->where('tipe', 1);
        // };
        // $akun   = $this->akun->get(['*'], $where);
        $sumberDana = $this->sumberDana->get();
        // return view('admin.sumber-dana.index', compact('sumberDana', 'akun')); 
        return view('admin.sumber-dana.index', compact('sumberDana'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SumberDanaRequest $request)
    {
        // $this->sumberDana->create([
        //     'nama_sumber_dana' => $request->nama_sumber_dana,
        //     'akun_id' => $request->akun,
        //     'nama_bank' => $request->nama_bank,
        //     'no_rekening' => $request->no_rekening,
        // ]);
        $this->sumberDana->create([
            'nama_sumber_dana'  => $request->nama_sumber_dana,
            'akun_id'           => $request->akun,
            'namaAkun'          => $request->namaAkun,
            'nama_bank'         => $request->nama_bank,
            'no_rekening'       => $request->no_rekening,
        ]);
        return redirect()->back()->with(['success' => 'Sumber dana berhasil disimpan']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SumberDanaRequest $request)
    {
         $this->sumberDana->update([
            'nama_sumber_dana' => $request->nama_sumber_dana,
            'akun_id' => $request->akun,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
         ], $request->id);
         return redirect()->back()
                ->with(['success' => 'Sumber dana berhasil di perbaharui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->sumberDana->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * get data sumber dana
     *
     * @return void
     */
    public function getData()
    {
        try {
            $sumberDana = $this->sumberDana->get();
            return response()->json([
                'status_code' => 200,
                'data' => $sumberDana,
                'total_data' => $sumberDana->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
        
    }
}
