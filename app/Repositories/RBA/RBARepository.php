<?php

namespace App\Repositories\RBA;

use App\Models\Rba;
use App\Models\Akun;
use App\Repositories\Repository;

class RBARepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Rba::class;
    }

    /**
     * Get Akun Id
     *
     * @param [type] $kodeAkun
     * @return void
     */
    public function getAkunId($kodeAkun)
    {
        $akun = Akun::where('kode_akun', $kodeAkun)->first();
        return $akun;
    }

    /**
     * Get data rba update
     *
     * @param [type] $kodeUnit
     * @param [type] $status
     * @param [type] $kodeRba
     * @return void
     */
    public function getRbaUpdate($id, $status, $kodeRba)
    {
        $rba = Rba::where('id', $id)
            ->where('status_anggaran_id', $status)
            ->where('kode_rba', $kodeRba)
            ->first();

        return $rba;
    }

    /**
     * Get Rba By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $tipe
     * @param [type] $kodeRba
     * @return void
     */
    public function getRba($unitKerja, $tipe, $kodeRba)
    {
        $rba = Rba::with(['rincianSumberDana.akun'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('tipe', $tipe)
            ->where('kode_rba', $kodeRba)
            ->first();
            
        return $rba;
    }

    /**
     * Get Rba By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $tipe
     * @param [type] $kodeRba
     * @return void
     */
    public function getRba221($unitKerja, $tipe, $kodeRba)
    {
        $rba = Rba::with(['rincianSumberDana.akun'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('tipe', $tipe)
            ->where('kode_rba', $kodeRba)
            ->get();

        return $rba;
    }

    /**
     * Get all rba with status perubahan murni
     * 
     * @param [string] kode unit kerja
     */
    public function getRbaMurni($request, $kodeUnit = null)
    {
        $rba = Rba::whereHas('statusAnggaran', function ($query) {
            $query->where('is_copyable', true);
        })->with(['statusAnggaran', 'mapKegiatan.blud']);
        
        if ($kodeUnit) {
            $rba->where('kode_unit_kerja', $kodeUnit);
        }

        if ($request->unit_kerja) {
            $rba->where('kode_unit_kerja', $request->unit_kerja);
        }

        if ($request->start_date) {
            $rba->where('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $rba->where('created_at', '<=', $request->end_date);
        }

        return $rba->get();

    }
}
