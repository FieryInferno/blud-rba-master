<?php

namespace App\Repositories\Organisasi;

use App\Models\SubKegiatan;
use App\Repositories\Repository;

class SubKegiatanRepository extends Repository
{

    public function model()
    {
        // return $this->subKegiatan;
        return SubKegiatan::class;
    }
}
