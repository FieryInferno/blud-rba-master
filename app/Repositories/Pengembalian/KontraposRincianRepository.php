<?php

namespace App\Repositories\Pengembalian;

use App\Models\KontraposRincian;
use App\Repositories\Repository;

class KontraposRincianRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return KontraposRincian::class;
    }

    /**
     * Delete all rincian kontrapos
     *
     * @param [type] $kontraposId
     * @return void
     */
    public function deleteAll($kontraposId)
    {
        return KontraposRincian::where('kontrapos_id', $kontraposId)->delete();
    }

    public function getKegiatanId($unitKerja)
    {
        $kontraposRincian = KontraposRincian::whereHas('kontrapos', function ($query) use($unitKerja){
            $query->where('kode_unit_kerja', $unitKerja);
        })->get();

        return $kontraposRincian->pluck('kegiatan_id');
    }
}
