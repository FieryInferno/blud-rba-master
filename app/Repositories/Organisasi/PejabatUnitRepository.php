<?php

namespace App\Repositories\Organisasi;

use App\Models\PejabatUnit;
use App\Repositories\Repository;

class PejabatUnitRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PejabatUnit::class;
    }
}
