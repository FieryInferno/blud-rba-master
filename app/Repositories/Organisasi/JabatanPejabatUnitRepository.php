<?php

namespace App\Repositories\Organisasi;

use App\Repositories\Repository;
use App\Models\JabatanPejabatUnit;

class JabatanPejabatUnitRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return JabatanPejabatUnit::class;
    }
}
