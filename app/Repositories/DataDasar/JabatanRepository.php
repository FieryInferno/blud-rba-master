<?php

namespace App\Repositories\DataDasar;

use App\Models\Jabatan;
use App\Repositories\Repository;

class JabatanRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Jabatan::class;
    }
}
