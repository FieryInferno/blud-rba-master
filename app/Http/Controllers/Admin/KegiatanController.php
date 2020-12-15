<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\KegiatanRequest;
use App\Models\MapKegiatan;
use App\Repositories\Organisasi\BidangRepository;
use App\Repositories\Organisasi\ProgramRepository;
use App\Repositories\Organisasi\KegiatanRepository;

class KegiatanController extends Controller
{
    /**
     * Kegiatan repository.
     * 
     * @var Kegiatan Repository
     */
    private $kegiatan;

    /**
     * Program repository.
     * 
     * @var ProgramRepository
     */
    private $program;

    /**
     * Bidang repository.
     * 
     * @var BidangRepository
     */
    private $bidang;

    /**
     * Constructor.
     */
    public function __construct(
        KegiatanRepository $kegiatan,
        ProgramRepository $program,
        BidangRepository $bidang
    ) {
        $this->kegiatan = $kegiatan;
        $this->program = $program;
        $this->bidang = $bidang;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where  = function ($query) {
            $query->whereNotNull('kode');
        };
        $kegiatan   = $this->kegiatan->get();
        $program    = $this->program->get(['*'], $where);
        $bidang     = $this->bidang->get(['*'], $where);
        return view('admin.kegiatan.index', compact('kegiatan', 'program', 'bidang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KegiatanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(KegiatanRequest $request)
    {
        $kegiatan = $this->kegiatan->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$kegiatan->nama_program} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param KegiatanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(KegiatanRequest $request)
    {
        $data = $request->only(['kode_bidang', 'kode_program', 'kode', 'nama_kegiatan']);
        $this->kegiatan->update($data, $request->id);
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
        $kegiatan       = $this->kegiatan->find($request->id);
        $mapKegiatan    = MapKegiatan::where('kegiatan_id_blud', $kegiatan->id)
            ->orWhere('kegiatan_id_apbd', $kegiatan->id)->first();

        if ($mapKegiatan){
            return redirect()->back()
                ->with(['error' => 'Kegiatan tidak dapat dihapus karena telah dipetakan ']);
        }
        
        $this->kegiatan->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
