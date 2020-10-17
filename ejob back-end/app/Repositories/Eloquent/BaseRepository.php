<?php

namespace App\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->query()->create($attributes);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(Model $model, array $attributes)
    {
        return $model->update($attributes);
    }

    public function get($orderBy = 'id' , $decsOrAsc = 'asc' , $with = [])
    {
        return $this->model->query()->with($with)->orderBy($orderBy , $decsOrAsc)->get();
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }

    public function find($value, $column = 'id'): Model
    {
        return $this->model->query()->where($column, $value)->firstOrFail();
    }
}
