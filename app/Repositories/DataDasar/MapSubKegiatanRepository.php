<?php

namespace App\Repositories\DataDasar;

use App\Models\MapSubKegiatan;
use App\Repositories\Repository;

class MapSubKegiatanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MapSubKegiatan::class;
    }
}