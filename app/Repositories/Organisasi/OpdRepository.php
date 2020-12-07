<?php

namespace App\Repositories\Organisasi;

use App\Models\Opd;
use App\Repositories\Repository;

class OpdRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Opd::class;
    }
}
