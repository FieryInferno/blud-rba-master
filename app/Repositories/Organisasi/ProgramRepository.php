<?php

namespace App\Repositories\Organisasi;

use App\Models\Program;
use App\Repositories\Repository;

class ProgramRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Program::class;
    }
}
