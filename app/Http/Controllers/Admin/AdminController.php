<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Rba;
use App\Models\Rka;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StatusAnggaran;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Repositories\RKA\RKARepository;
use App\Repositories\User\UserRepository;

class AdminController extends Controller
{
    /**
     * User Repository.
     *
     * @var UserRepository $user
     */
    private $user;

    /**
     * Unit kerja repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * Construct.
     */
    public function __construct(
        UserRepository $user,
        RBARepository $rba,
        RKARepository $rka
    )
    {
        $this->user = $user;
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
        $user = $this->user->find(auth()->user()->id, ['*'], ['role', 'unitKerja']);

        $condition = function ($query) use($user){
            $query->where('tipe', auth()->user()->status);
            
            if ($user->role->role_name == Role::ROLE_PUSKESMAS){
                $query->where('kode_unit_kerja', $user->unitKerja->kode);
            }
        };
        
        /** RBA */
        $rba = $this->rba->get(['*'], $condition, ['rincianSumberDana']);

        $totalRba1 = 0;
        $totalRba221 = 0;
        $totalRba31 = 0;

        foreach ($rba as $item) {
            if ($item->getOriginal('kode_rba') == Rba::KODE_RBA_1) {
                $totalRba1 = +$item->rincianSumberDana->sum('nominal');
            } else if ($item->getOriginal('kode_rba') == Rba::KODE_RBA_221) {
                $totalRba221 = +$item->rincianSumberDana->sum('nominal');
            } else if ($item->getOriginal('kode_rba') == Rba::KODE_RBA_31) {
                $totalRba31 = +$item->rincianSumberDana->sum('nominal');
            }
        }

        $totalRba = ($totalRba1 + $totalRba31) - $totalRba221; 
        $data['total_rba'] = $totalRba;

        /** RKA */
        $rka = $this->rka->get(['*'], $condition, ['rincianSumberDana']);

        $totalRka1 = 0;
        $totalRka21 = 0;
        $totalRka221 = 0;

        foreach ($rka as $item) {
            if ($item->getOriginal('kode_rka') == Rka::KODE_RKA_1) {
                $totalRka1 = +$item->rincianSumberDana->sum('nominal');
            } else if ($item->getOriginal('kode_rka') == Rka::KODE_RKA_21) {
                $totalRka21 = +$item->rincianSumberDana->sum('nominal');
            } else if ($item->getOriginal('kode_rka') == Rka::KODE_RKA_221) {
                $totalRka221 = +$item->rincianSumberDana->sum('nominal');
            }
        }

        $totalRka = ($totalRka1 + $totalRka21) - $totalRka221;
        $data['total_rka'] = $totalRka;

        return view('admin.index', compact('data'));
    }

    /**
     * Admin Page
     *
     * @return void
     */
    public function adminPage()
    {
        $statusAnggaran = StatusAnggaran::get();
        return view('admin.admin-page', compact('status', 'statusAnggaran'));
    }

    /**
     * Update status.
     * 
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $request->validate(['status' => 'required']);
        $ids = User::all()->pluck('id');
        User::whereIn('id', $ids)->update(['status_anggaran_id' => $request->status]);

        return redirect()->back()
                ->with(['success' => 'Status berhasil diubah']);
    }
}
