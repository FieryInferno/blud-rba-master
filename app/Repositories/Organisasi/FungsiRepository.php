<?php

namespace App\Repositories\Organisasi;

use App\Models\Fungsi;
use App\Repositories\Repository;

class FungsiRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Fungsi::class;
    }
}
