<?php

namespace App\Repositories\BKU;

use App\Models\Bku;
use App\Repositories\Repository;

class BKURepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Bku::class;
    }

    /**
     * Get Last data of tbp
     *
     * @return void
     */
    public function getLastBku($kodeUnit)
    {
        return Bku::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Delete all bku
     *
     * @param [inr] $id
     * @return void
     */
    public function deleteAll($id)
    {
        return Bku::whereIn('id', $id)->delete();
    }

    /**
     * get data on report bku
     *
     * @param [type] $startDate
     * @param [type] $endDate
     * @return void
     */
    public function reportBku($kodeUnitKerja, $startDate, $endDate)
    {
        $bku = Bku::with(['bkuRincian'])
            ->where('kode_unit_kerja', $kodeUnitKerja)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();
        
        return $bku;
    }
}
