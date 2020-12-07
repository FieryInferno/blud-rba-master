<?php

namespace App\Repositories\Organisasi;

use App\Models\UnitKerja;
use App\Repositories\Repository;

class UnitKerjaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return UnitKerja::class;
    }
}
