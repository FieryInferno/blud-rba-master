<?php

namespace App\Repositories\DataDasar;

use App\Models\Ssh;
use App\Repositories\Repository;

class SSHRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Ssh::class;
    }
}
