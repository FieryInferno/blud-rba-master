<?php

namespace App\Repositories\DataDasar;

use App\Models\SumberDana;
use App\Repositories\Repository;

class SumberDanaRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return SumberDana::class;
    }
}
