<?php

namespace App\Repositories\RKA;

use App\Repositories\Repository;
use App\Models\RkaIndikatorKerja;

class RKAIndikatorKerjaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RkaIndikatorKerja::class;
    }

    /**
     * Delete indikator kerja
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rkaId)
    {
        return $this->model->where('rka_id', $rkaId)->forceDelete();
    }

}
