<?php

namespace App\Repositories\RBA;

use App\Repositories\Repository;
use App\Models\RbaIndikatorKerja;

class RBAIndikatorKerjaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RbaIndikatorKerja::class;
    }

    /**
     * Delete indikator kerja
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rbaId)
    {
        return $this->model->where('rba_id', $rbaId)->forceDelete();
    }

}
