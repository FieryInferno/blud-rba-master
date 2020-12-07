<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\RepositoryException;
use App\Repositories\RepositoryInterface;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var App
     */
    private $app;
 
    /**
     * @var
     */
    protected $model;
 
    /**
     * Constructor.
     * 
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }
 
    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public abstract function model();
 
    /**
     * Get all resources.
     * 
     * @param array $columns
     * @param mixed $where
     * @param array $with
     * @return mixed
     */
    public function get($columns = ['*'], $where = null, $with = []) {
        $builder = $this->model;

        if ($with) {
            $builder = $builder->with($with);
        }

        if ($where) {
            $builder = $builder->where($where);
        }

        return $builder->get($columns);
    }
 
    /**
     * Get resources with pagination.
     * 
     * @param int $perPage
     * @param int $page
     * @param array $columns
     * @param mixed $where
     * @param array $with
     * @return mixed
     */
    public function paginate(
        $perPage = 10,
        $page = 1,
        $columns = ['*'],
        $where = null,
        $with = [],
        $orderBy = null
    ) {
        $builder = $this->model;

        if ($with) {
            $builder = $builder->with($with);
        }

        if ($where) {
            $builder = $builder->where($where);
        }

        if($orderBy) {
            $builder = $builder->orderBy($orderBy, 'DESC');
        }

        return $builder->paginate(
            $perPage, $columns, 'page', $page
        );
    }
 
    /**
     * Create new resource.
     * 
     * @param array $data
     * @return mixed
     */
    public function create($data) {
        return $this->model->create($data);
    }
 
    /**
     * Update the resouce.
     * 
     * @param array $data
     * @param string|int $id
     * @param string $attribute
     * @return mixed
     */
    public function update($data, $id, $attribute = 'id') {
        return $this->model->where($attribute, '=', $id)->update($data);
    }
 
    /**
     * Delete the resource.
     * 
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->find($id)->delete();
    }
 
    /**
     * Find the resource.
     * 
     * @param $id
     * @param array $columns
     * @param array $with
     * @return mixed
     */
    public function find($id, $columns = ['*'], $with = []) {
        if ($with) {
            return $this->model->with($with)->find($id, $columns);
        }

        return $this->model->find($id, $columns);
    }
 
    /**
     * Find resouce by attribute.
     * 
     * @param $attribute
     * @param $operator
     * @param $value
     * @param array $columns
     * @param array $with
     * @return mixed
     */
    public function findBy($attribute, $operator, $value, $columns = ['*'], $with = []) {
        if ($with) {
            return $this->model->with($with)->where($attribute, '=', $value)->first($columns);
        }

        return $this->model->where($attribute, '=', $value)->first($columns);
    }
 
    /**
     * Make model.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());
 
        if (! $model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
 
        return $this->model = $model->newQuery();
    }
}
