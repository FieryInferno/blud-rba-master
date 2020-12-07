<?php

namespace App\Repositories\RBA;

use App\Repositories\Repository;
use App\Models\RbaRincianAnggaran;

class RBARincianAnggaranRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RbaRincianAnggaran::class;
    }

    /**
     * Delete rincian anggaran
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rbaId)
    {
        return $this->model->where('rba_id', $rbaId)->forceDelete();
    }

}
