<?php

namespace App\Http\Controllers\Admin\RBA;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Repositories\User\UserRepository;

class RBAController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * User Repository.
     *
     * @var UserRepository $user
     */
    private $user;

     /**
     * Construct.
     */
    public function __construct(
        RBARepository $rba,
        UserRepository $user
    )
    {
        $this->user = $user;
        $this->rba = $rba;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereRba = function ($query) use($user){
            $query->where('tipe', auth()->user()->status);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };

        $rba = $this->rba->get(['*'], $whereRba, ['rincianSumberDana', 'unitKerja', 'mapKegiatan.blud']);
        $rba->map(function ($item) {
            $item->rba_tipe = str_replace('_', '', $item->getOriginal('kode_rba'));
        });

        $rba->sum(function ($rba){
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
        });
    
        return view('admin.rba.rba.index', compact('rba'));
    }
}
