<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisasi\UrusanRequest;
use App\Repositories\Organisasi\UrusanRepository;
use App\Http\Requests\Organisasi\UrusanEditRequest;

class UrusanController extends Controller
{
    /**
     * Urusan repository.
     * 
     * @var UrusanController
     */
    private $urusan;

    /**
     * Constructor.
     */
    public function __construct(UrusanRepository $urusan)
    {
        $this->urusan = $urusan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urusan = $this->urusan->get();
        return view('admin.urusan.index', compact('urusan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UrusanRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrusanRequest $request)
    {
        $urusan = $this->urusan->create($request->only(['kode', 'nama_urusan']));
        return redirect()->back()
                ->with(['success' => "{$urusan->nama_urusan} berhasil disimpan"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UrusanEditRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UrusanEditRequest $request)
    {
        $this->urusan->update($request->only('nama_urusan'), $request->id);
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
        $this->urusan->delete($request->id);
        return redirect()->back()
                ->with(['success' => 'Data berhasil dihapus']);
    }
}
