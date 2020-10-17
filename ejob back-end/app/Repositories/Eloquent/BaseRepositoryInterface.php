<?php

namespace App\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param string $column
     * @param $value
     * @return Model
     */
    public function find($value , $column = 'id'): Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param Model $model
     * @param array $attributes
     * @return mixed
     */
    public function update(Model $model, array $attributes);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param Model $model
     * @return mixed
     */
    public function delete(Model $model);
}
