<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function count()
    {
        return new $this->model->count();
    }

    public function find($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    public function new()
    {
        return new $this->model();
    }

    public function next_id($column = 'id')
    {
        return $this->model->max($column) + 1;
    }

    public function save(Model $model)
    {
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->delete();

        return $model;
    }

    public function changeState($id, $estado, $with = [], $column = 'state')
    {
        $model = $this->model->with($with)->find($id);
        $model[$column] = $estado;
        $model->save();

        return $model;
    }

    public function select2($text = 'name', $key = 'state')
    {
        return $this->model->where($key, 1)->get()->map(function ($value) use ($text) {
            return [
                'id' => $value->id,
                'text' => $value[$text],
            ];
        });
    }

    public function select2Relation($text = 'name', $relation = 'user', $key = 'state')
    {
        return $this->model->whereRelation($relation, $key, 1)->get();
    }

    public function select($order = 'name')
    {
        return $this->model->orderBy($order)->where('state', 'Activo')->get();
    }
}
