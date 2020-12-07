<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\RbaRincianAnggaran;
use App\Models\RkaRincianAnggaran;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\SSHRequest;
use App\Repositories\DataDasar\SSHRepository;
use App\Repositories\DataDasar\AkunRepository;

class SSHController extends Controller
{
    /**
     * SSH repository.
     * 
     * @var SSHRepository
     */
    private $ssh;
    
    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        SSHRepository $ssh
    )
    {
        $this->akun = $akun;
        $this->ssh = $ssh;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = function ($query) {
            $query->where('tipe', 5)
                ->where('is_parent', false);
        };
        $akun = $this->akun->get(['*'], $where);
        $ssh = $this->ssh->get();
        return view('admin.ssh.index', compact('akun', 'ssh')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SSHRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SSHRequest $request)
    {
        $ssh = $this->ssh->create([
            'golongan' => $request->golongan,
            'bidang' => $request->bidang,
            'kelompok' => $request->kelompok,
            'sub1' => $request->sub1,
            'sub2' => $request->sub2,
            'sub3' => $request->sub3,
            'sub4' => $request->sub4,
            'kode_akun' => $request->kode_akun,
            'kode' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'merk' => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'harga' => $request->harga,
        ]);
        return redirect()->back()
                ->with(['success' => "{$ssh->nama_barang} berhasil disimpan"]);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param SSHRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SSHRequest $request)
    {
        $this->ssh->update([
            'golongan' => $request->golongan,
            'bidang' => $request->bidang,
            'kelompok' => $request->kelompok,
            'sub1' => $request->sub1,
            'sub2' => $request->sub2,
            'sub3' => $request->sub3,
            'sub4' => $request->sub4,
            'kode_akun' => $request->kode_akun,
            'kode' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'merk' => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'harga' => parse_idr($request->harga),
        ], $request->id);
        return redirect()->back()
                ->with(['success' => "Data berhasil disimpan"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rincianRba = RbaRincianAnggaran::with('rba')->where('ssh_id', $request->id)->first();
        if ($rincianRba && $rincianRba->rba) {
            return redirect()->back()
                ->with(['error' => 'Standard Barang tidak dapat dihapus karena digunakan pada RBA']);
        }

        $rincianRka = RkaRincianAnggaran::with('rka')->where('ssh_id', $request->id)->first();
        if ($rincianRka && $rincianRka->rka) {
            return redirect()->back()
                ->with(['error' => 'Standard Barang tidak dapat dihapus karena digunakan pada RKA']);
        }

        $this->ssh->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * Get data ssh
     *
     * @param Request $request
     * @return void
     */
    public function getData(Request $request)
    {
        try {
            $kodeAkun = $request->kode_akun;
            $where = function ($query) use($kodeAkun){
                $query->where('kode_akun', $kodeAkun);
            };

            $ssh = $this->ssh->get(['*'], $where)
                    ->sortBy('nama_barang')
                    ->values()
                    ->all();

            return response()->json([
                'status_code' => 200,
                'data' => $ssh,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
