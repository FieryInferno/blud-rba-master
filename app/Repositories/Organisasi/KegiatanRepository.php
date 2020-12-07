<?php

namespace App\Repositories\Organisasi;

use App\Models\Kegiatan;
use App\Repositories\Repository;

class KegiatanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Kegiatan::class;
    }
}
