<?php

namespace App\Repositories\DataDasar;

use App\Models\PejabatDaerah;
use App\Repositories\Repository;

class PejabatDaerahRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PejabatDaerah::class;
    }
}
