<?php

namespace App\Repositories\StatusAnggaran;

use App\Models\StatusAnggaran;
use App\Repositories\Repository;

class StatusAnggaranRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return StatusAnggaran::class;
    }

}
