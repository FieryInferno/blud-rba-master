<?php

namespace App\Repositories\DataDasar;

use App\Models\MapAkun;
use App\Repositories\Repository;

class MapAkunRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MapAkun::class;
    }
}
