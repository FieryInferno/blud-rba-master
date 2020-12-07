<?php

namespace App\Repositories\RKA;

use App\Models\Rka;
use App\Models\Akun;
use App\Models\RkaRincianSumberDana;
use App\Models\SumberDana;
use App\Repositories\Repository;

class RKARepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Rka::class;
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
     * Get Rka Update
     *
     * @param [type] $kodeUnit
     * @param [type] $status
     * @param [type] $kodeRka
     * @return void
     */
    public function getRbaUpdate($kodeUnit, $status, $kodeRka)
    {
        $rka = Rka::where('kode_unit_kerja', $kodeUnit)
            ->where('tipe', $status)
            ->where('kode_rka', $kodeRka)
            ->first();

        return $rka;
    }

    /**
     * Get Rka By UnitKerja, Tipe and Kode
     *
     * @param [type] $unitKerja
     * @param [type] $tipe
     * @param [type] $kodeRba
     * @return void
     */
    public function getRka221($unitKerja, $tipe, $kodeRka)
    {
        $rka = Rka::with(['rincianSumberDana.akun', 'rincianSumberDana.sumberDana'])
            ->where('kode_unit_kerja', $unitKerja)
            ->where('tipe', $tipe)
            ->where('kode_rka', $kodeRka)
            ->get();

        return $rka;
    }

    public function cekSumberDana($rkaId, $akunId)
    {
        $rka = RkaRincianSumberDana::with(['sumberDana' => function ($query) {
            $query->where('nama_sumber_dana', SumberDana::APBD);
        }])
            ->where('rka_id', $rkaId)
            ->where('akun_id', $akunId)
            ->first();

        $rkaExist = $rka ? true : false;

        return $rkaExist;
    }

    /**
     * Get all rka with status perubahan murni
     * 
     * @param [string] kode unit kerja
     */
    public function getRkaMurni($request, $kodeUnit = null)
    {
        $rba = Rka::whereHas('statusAnggaran', function ($query) {
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
