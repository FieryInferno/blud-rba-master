<?php

namespace App\Repositories\RKA;

use App\Repositories\Repository;
use App\Models\RkaRincianAnggaran;

class RKARincianAnggaranRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RkaRincianAnggaran::class;
    }

    /**
     * Delete rincian anggaran
     *
     * @param [type] $rbaId
     * @return void
     */
    public function deleteAll($rbaId)
    {
        return $this->model->where('rka_id', $rbaId)->forceDelete();
    }

}
