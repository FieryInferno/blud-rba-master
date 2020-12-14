<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\AkunRequest;
use App\Repositories\DataDasar\SSHRepository;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\DataDasar\KategoriAkunRepository;
use App\Repositories\RBA\RBARepository;
use App\Repositories\RKA\RKARepository;
use App\Models\Akun;

class AkunController extends Controller
{
    /**
     * Akun repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Kategori repository.
     * 
     * @var KategorRepository
     */
    private $kategori;

    /**
     * SSH repository.
     * 
     * @var SSHRepository
     */
    private $ssh;

    /**
     * SSH repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * SSH repository.
     * 
     * @var RKARepository
     */
    private $rka;

    /**
     * Constructor.
     */
    public function __construct(
        AkunRepository $akun,
        KategoriAkunRepository $kategori,
        SSHRepository $ssh,
        RBARepository $rba,
        RKARepository $rka
    ) {
        $this->akun = $akun;
        $this->kategori = $kategori;
        $this->ssh = $ssh;
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
        $kategori = $this->kategori->get();
        $akun = $this->akun->get();
        return view('admin.akun.index', compact('akun', 'kategori')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunRequest $request)
    {
        $akun = $this->akun->create([
            'tipe' => $request->tipe,
            'kelompok' => $request->kelompok,
            'jenis' => $request->jenis,
            'objek' => $request->objek,
            'rincian' => $request->rincian,
            'sub1' => $request->sub1,
            'sub2' => $request->sub2,
            'sub3' => $request->sub3,
            'nama_akun' => $request->nama_akun,
            'kode_akun' => $request->kode_akun,
            'kategori_id' => $request->kategori,
            'pagu' => parse_idr($request->pagu),
            'is_parent' => $request->is_parent
        ]);
        return redirect()->back()
                ->with(['success' => "{$akun->nama_akun} berhasil disimpan"]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AkunRequest $request)
    {
        $akun = $this->akun->find($request->id);
        $akun->tipe = $request->tipe;
        $akun->kelompok = $request->kelompok;
        $akun->jenis = $request->jenis;
        $akun->objek = $request->objek;
        $akun->rincian = $request->rincian;
        $akun->sub1 = $request->sub1;
        $akun->sub2 = $request->sub2;
        $akun->sub3 = $request->sub3;
        $akun->nama_akun = $request->nama_akun;
        $akun->kode_akun = $request->kode_akun;
        $akun->kategori_id = $request->kategori;
        $akun->pagu = parse_idr($request->pagu);
        $akun->is_parent = $request->is_parent;
        $akun->save();
        return redirect()->back()
                ->with(['success' => "{$akun->nama_akun} berhasil disimpan"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->akun->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }

    /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getDataParent(Request $request)
    {
        try {
            $where = function ($query) use($request){
                $query->where('tipe', $request->tipe);
                if ($request->kelompok){
                    $query->where('kelompok', $request->kelompok);
                }
                if ($request->jenis){
                    $query->where('jenis', $request->jenis);
                }
                $query->where('is_parent', true);
            };
            $akun = $this->akun->get(['*'], $where);
            return response()->json([
                'status_code' => 200,
                'data' => $akun,
                'total_data' => $akun->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getAkunRka21(Request $request)
    {
        try {
            $akun = $this->akun->getParentRka21();
            
            return response()->json([
                'status_code' => 200,
                'data' => $akun,
                'total_data' => $akun->count()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getAkun5Rba(Request $request)
    {
        try {
            $data = [];
            $requestData = [];

            foreach ($request->rekening as $index => $item) {
                $kode = substr($item['kode_akun'], 0, 8);
                if (! in_array($kode, $data)) {
                    $data[] = $kode;
                }

                $requestData[$index] = $item;
                $where = function ($query) use ($item) {
                    $query->where('kode_akun', $item['kode_akun']);
                };
                $requestData[$index]['ssh'] = $this->ssh->get(['*'], $where)->sortBy('nama_barang')->values()->all();
                $this->ssh->makeModel();
            }

            $results = collect($requestData);
            foreach ($data as $item) {
                $explode = explode('.', $item);
                $results = $results->merge($this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3]));
            }

            $unique = $results->unique('kode_akun');
            $results = $unique->sortBy('kode_akun')->values()->all();

            $rba = $this->rba->find($request->rba_id, ['*'], ['rincianAnggaran.akun']);
            if ($rba){
                $rincianAnggaran = $rba->rincianAnggaran;
                
                $rincianAnggaran = $rincianAnggaran->map(function ($item){
                    $item->kode_akun = $item->akun->kode_akun;
                    return $item;
                });
            }
            
            return response()->json([
                'status_code' => 200,
                'data' => [
                    'akun' => $results ?? [],
                    'rincian' => $rincianAnggaran ?? []
                ]
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ], 400);
        }
    }

        /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getAkun5Rka(Request $request)
    {
        try {
            $data = [];
            $requestData = [];

            foreach ($request->rekening as $index => $item) {
                $kode = substr($item['kode_akun'], 0, 8);
                if (! in_array($kode, $data)) {
                    $data[] = $kode;
                }

                $requestData[$index] = $item;
                $where = function ($query) use ($item) {
                    $query->where('kode_akun', $item['kode_akun']);
                };
                $requestData[$index]['ssh'] = $this->ssh->get(['*'], $where)->sortBy('nama_barang')->values()->all();
                $this->ssh->makeModel();
            }

            $results = collect($requestData);
            foreach ($data as $item) {
                $explode = explode('.', $item);
                $results = $results->merge($this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3]));
            }

            $unique = $results->unique('kode_akun');
            $results = $unique->sortBy('kode_akun')->values()->all();

            $rka = $this->rka->find($request->rka_id, ['*'], ['rincianAnggaran.akun']);
            if ($rka){
                $rincianAnggaran = $rka->rincianAnggaran;
                
                $rincianAnggaran = $rincianAnggaran->map(function ($item){
                    $item->kode_akun = $item->akun->kode_akun;
                    return $item;
                });
            }
            
            return response()->json([
                'status_code' => 200,
                'data' => [
                    'akun' => $results ?? [],
                    'rincian' => $rincianAnggaran ?? []
                ]
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getAkunDataRba(Request $request)
    {
        try {

            $data = [];
            $requestData = [];
            
            if ($request->rekening){
                foreach ($request->rekening as $index => $item) {
                    $kode = substr($item['kode_akun'], 0, 8);
                    if (! in_array($kode, $data)) {
                        $data[] = $kode;
                    }
    
                    $requestData[$index] = $item;
                    $where = function ($query) use ($item) {
                        $query->where('kode_akun', $item['kode_akun']);
                    };
                }
    
                $results = collect($requestData);
                foreach ($data as $item) {
                    $explode = explode('.', $item);
                    $results = $results->merge($this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3]));
                }
    
                $unique = $results->unique('kode_akun');
                $results = $unique->sortBy('kode_akun')->values()->all();
    
                $rba = $this->rba->find($request->rba_id, ['*'], ['rincianAnggaran.akun']);
                $rincianAnggaran = $rba->rincianAnggaran;
                
                $rincianAnggaran = $rincianAnggaran->map(function ($item){
                    $item->kode_akun = $item->akun->kode_akun;
                    $item->satuan = $item->satuan ?? '';
                    $item->keterangan = $item->keterangan ?? '';
                    return $item;
                });
                
                
            }

            return response()->json([
                'status_code' => 200,
                'data' => [
                    'akun' => $results ?? [],
                    'rincian' => $rincianAnggaran ?? []
                ]
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get data akun parent 
     *
     * @param Request $request
     * @return void
     */
    public function getAkunDataRka(Request $request)
    {
        try {

            $data = [];
            $requestData = [];

            if ($request->rekening){
                foreach ($request->rekening as $index => $item) {
                    $kode = substr($item['kode_akun'], 0, 8);
                    if (! in_array($kode, $data)) {
                        $data[] = $kode;
                    }
    
                    $requestData[$index] = $item;
                    $where = function ($query) use ($item) {
                        $query->where('kode_akun', $item['kode_akun']);
                    };
                }
    
                $results = collect($requestData);
                foreach ($data as $item) {
                    $explode = explode('.', $item);
                    $results = $results->merge($this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3]));
                }
    
                $unique = $results->unique('kode_akun');
                $results = $unique->sortBy('kode_akun')->values()->all();
    
                $rka = $this->rka->find($request->rka_id, ['*'], ['rincianAnggaran.akun']);
                $rincianAnggaran = $rka->rincianAnggaran;
                
                $rincianAnggaran = $rincianAnggaran->map(function ($item){
                    $item->kode_akun = $item->akun->kode_akun;
                    $item->satuan = $item->satuan ?? '';
                    $item->keterangan = $item->keterangan ?? '';
                    return $item;
                });
                
                
            }

            return response()->json([
                'status_code' => 200,
                'data' => [
                    'akun' => $results ?? [],
                    'rincian' => $rincianAnggaran ?? []
                ]
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage(),
            ], 400);
        }
    }

    public function updateKodeAkun()
    {
        $akunLama   = $this->akun->get()->toArray();
        $j  = 1;
        for ($i=0; $i < count($akunLama); $i++) { 
            $key        = $akunLama[$i];
            $kodeAkun   = $key['tipe'];
            if ($key['kelompok']) $kodeAkun .= '.' . $key['kelompok'];
            if ($key['jenis']) $kodeAkun    .= '.' . $key['jenis']; 
            if ($key['objek']) $kodeAkun    .= '.' . $key['objek'];
            if ($key['rincian']) $kodeAkun  .= '.' . $key['rincian'];
            if ($key['sub1']) $kodeAkun     .= '.' . $key['sub1'];
            if ($key['sub2']) $kodeAkun     .= '.' . $key['sub2'];
            if ($key['sub3']) $kodeAkun     .= '.' . $key['sub3'];
            $akunBaru                       = Akun::find($j);
            $akunBaru->kode_akun            = $kodeAkun;
            $akunBaru->save();
            $j++;
        }
    }
}
