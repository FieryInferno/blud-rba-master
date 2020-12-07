<?php

namespace App\Repositories\DataDasar;

use App\Models\MapKegiatan;
use App\Repositories\Repository;

class MapKegiatanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MapKegiatan::class;
    }
}
