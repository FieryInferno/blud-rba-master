<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function get($columns = ['*'], $where = null, $with = []);

    public function paginate($perPage = 10, $page = 1, $columns = ['*'], $where = null, $with = []);

    public function find($id, $columns = ['*'], $with = []);

    public function findBy($attribute, $operator, $value, $columns = ['*'], $with = []);

    public function create($data);

    public function update($data, $id, $attribute = 'id');

    public function delete($id);
}
