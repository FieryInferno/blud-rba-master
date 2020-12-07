<?php

namespace App\Repositories\RKA;

use App\Models\Rba;
use App\Repositories\Repository;
use App\Models\RkaRincianSumberDana;

class RKARincianSumberDanaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RkaRincianSumberDana::class;
    }

    /**
     * delete rincian sumber dana 
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rbaId)
    {
        return $this->model->where('rka_id', $rbaId)->forceDelete();
    }
}
