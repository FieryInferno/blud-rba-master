<?php

namespace App\Repositories\DataDasar;

use App\Models\KategoriAkun;
use App\Repositories\Repository;

class KategoriAkunRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return KategoriAkun::class;
    }
}
