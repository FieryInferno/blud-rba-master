<?php

namespace App\Repositories\Organisasi;

use App\Models\Bidang;
use App\Repositories\Repository;

class BidangRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Bidang::class;
    }
}
