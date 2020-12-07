<?php

namespace App\Repositories\Organisasi;

use App\Models\Urusan;
use App\Repositories\Repository;

class UrusanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Urusan::class;
    }
}
