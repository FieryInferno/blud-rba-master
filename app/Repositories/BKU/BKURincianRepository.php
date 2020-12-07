<?php

namespace App\Repositories\BKU;

use App\Models\BkuRincian;
use App\Models\KontraposRincian;
use App\Models\StsRincian;
use App\Repositories\Repository;

class BKURincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return BkuRincian::class;
    }

    /**
     * Delete all rincian tbp
     *
     * @param [type] $tbpId
     * @return void
     */
    public function deleteAll($bkuId)
    {
        return BkuRincian::where('bku_id', $bkuId)->delete();
    }

    public function deleteMany($bkuId)
    {
        return BkuRincian::whereIn('bku_id', $bkuId)->delete();
    }

    /**
     * Get al bku rincian
     *
     * @param [type] $kodeUnitKerja
     * @param [type] $tanggalAwal
     * @param [type] $tanggalAkhir
     * @return void
     */
    public function getAllBkuRincian($kodeUnitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return BkuRincian::whereHas('bku', function ($query) use($kodeUnitKerja, $tanggalAwal, $tanggalAkhir) {
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->with(['bku', 'sts'])
            ->get();
    }

    /**
     * Get all rincian sts
     *
     * @param [type] $kodeUnitKerja
     * @param [type] $tanggalAwal
     * @param [type] $tanggalAkhir
     * @return void
     */
    public function getAllBkuStsRincian($kodeUnitKerja, $tanggalAwal, $tanggalAkhir)
    {
        return BkuRincian::whereHas('bku', function ($query) use ($kodeUnitKerja, $tanggalAwal, $tanggalAkhir) {
            $query->where('kode_unit_kerja', $kodeUnitKerja)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->with(['bku', 'sts'])
            ->where('tipe', BkuRincian::STS)
            ->get();
    }

    /**
     * getBkuRIncian
     *
     * @param [type] $kodeUnitKerja
     * @return void
     */
    public function getBkuRincian($kodeUnitKerja)
    {
        return BkuRincian::whereHas('bku', function ($query) use($kodeUnitKerja) {
            $query->where('kode_unit_kerja', $kodeUnitKerja);
        })->get();
    }

    public function getKontraposBku($kodeUnitKerja, $kodeAkun)
    {
        return KontraposRincian::whereHas('kontrapos.bkuRincian.bku', function ($query) use($kodeUnitKerja) {
            $query->where('kode_unit_kerja', $kodeUnitKerja);
        })
            ->whereIn('kode_akun', $kodeAkun)
            ->get();
    }


}
