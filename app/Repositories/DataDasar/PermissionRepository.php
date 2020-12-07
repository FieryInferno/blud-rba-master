<?php

namespace App\Repositories\DataDasar;

use App\Models\Permission;
use App\Repositories\Repository;

class PermissionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Permission::class;
    }
}
