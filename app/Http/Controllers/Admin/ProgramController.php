<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\ProgramRequest;
use App\Repositories\Organisasi\BidangRepository;
use App\Repositories\Organisasi\ProgramRepository;

class ProgramController extends Controller
{
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
    public function __construct(ProgramRepository $program, BidangRepository $bidang)
    {
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
        $program = $this->program->get();

        $where = function ($query) {
            $query->whereNotNull('kode');
        };
        $bidang = $this->bidang->get(['*'], $where);
        return view('admin.program.index', compact('program', 'bidang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProgramRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        $program = $this->program->create($request->all());
        return redirect()->back()
                ->with(['success' => "{$program->nama_program} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProgramRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request)
    {
        $data = $request->only(['kode_bidang', 'kode', 'nama_program']);
        $this->program->update($data, $request->id);
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
        $this->program->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
