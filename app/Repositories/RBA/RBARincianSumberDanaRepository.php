<?php

namespace App\Repositories\RBA;

use App\Models\Rba;
use App\Repositories\Repository;
use App\Models\RbaRincianSumberDana;

class RBARincianSumberDanaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RbaRincianSumberDana::class;
    }

    /**
     * delete rincian sumber dana 
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rbaId)
    {
        return $this->model->where('rba_id', $rbaId)->forceDelete();
    }
}
