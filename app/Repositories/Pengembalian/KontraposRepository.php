<?php

namespace App\Repositories\Pengembalian;

use App\Models\Kontrapos;
use App\Repositories\Repository;

class KontraposRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Kontrapos::class;
    }

    /**
     * Get Last data of spd
     *
     * @return void
     */
    public function getLastKontrapos($kodeUnit)
    {
        return Kontrapos::where('nomor_otomatis', true)
            ->where('kode_unit_kerja', $kodeUnit)
            ->orderBy('id', 'desc')
            ->first();
    }
}
