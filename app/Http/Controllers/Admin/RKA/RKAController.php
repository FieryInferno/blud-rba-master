<?php

namespace App\Http\Controllers\Admin\RKA;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RKA\RKARepository;
use App\Repositories\User\UserRepository;

class RKAController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var RKARepository
     */
    private $rka;

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
        RKARepository $rka,
        UserRepository $user
    ) {
        $this->user = $user;
        $this->rka = $rka;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $whereRka = function ($query) use ($user) {
            $query->where('status_anggaran_id', auth()->user()->statusAnggaran->id);

            if ($user->role->role_name == Role::ROLE_PUSKESMAS) {
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }

        };

        $rka = $this->rka->get(['*'], $whereRka, ['rincianSumberDana', 'unitKerja', 'mapKegiatan.blud']);
        $rka->map(function ($item) {
            $item->rka_tipe = str_replace('_', '', $item->getOriginal('kode_rka'));
        });

        $rka->sum(function ($rba) {
            $rba->total_nominal_murni = $rba->rincianSumberDana->sum('nominal');
            $rba->total_nominal_pak = $rba->rincianSumberDana->sum('nominal_pak');
        });

        $rka = $rka->sortByDesc('created_at');

        return view('admin.rka.rka.index', compact('rka'));
    }
}
