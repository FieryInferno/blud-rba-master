<?php

namespace App\Repositories\DataDasar;

use App\Models\Role;
use App\Repositories\Repository;

class RoleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Role::class;
    }
}
