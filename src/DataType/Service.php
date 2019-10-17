<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Isneezy\Timoneiro\Http\Controllers\ContentTypes\Password;
use Isneezy\Timoneiro\Http\Controllers\ContentTypes\Text;

class Service implements ServiceInterface
{
    public function findAll($keyword = '', array $data = [])
    {
        $query = $this->newQuery();
        if ($keyword) {
            $searchable = $this->getDataType()->field_set;
            $query->where(function (Builder $query) use ($keyword, $searchable) {
                foreach ($searchable as $column) {
                    if ($column->persist) {
                        $query->orWhere($column->name, 'LIKE', "%$keyword%");
                    }
                }
            });
        }

        $orderBy = Arr::get($data, 'sort.column');
        $sortOrder = Arr::get($data, 'sort.direction');

        if ($orderBy && $sortOrder) {
            $query->orderBy($orderBy, $sortOrder);
        }

        $perPage = Arr::get($data, 'limit', 10);

        return $query->paginate($perPage);
    }

    /**
     * @param $id
     *
     * @return Collection|Model
     */
    public function find($id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * @param Model | integer | string $model
     * @param array                    $data
     *
     * @return Model
     */
    public function update($model, array $data)
    {
        $dataType = $this->getDataType();
        if (!$model instanceof Model) {
            $model = $this->find($model);
        }

        return $this->insertOrUpdate($data, $dataType->slug, $dataType->field_set, $model);
    }

    public function create(array $data)
    {
        $dataType = $this->getDataType();

        return $this->insertOrUpdate($data, $dataType->slug, $dataType->field_set, $this->getModel());
    }

    /**
     * @return AbstractDataType
     */
    public function getDataType()
    {
        return app(AbstractDataType::class);
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return app($this->getDataType()->model_name);
    }

    /**
     * @param array $data
     *
     * @return Builder
     */
    public function newQuery($data = [])
    {
        $model = $this->getModel();
        $query = $model->newQuery();

        foreach ($this->getDataType()->scopes as $scope) {
            $query = $query->{$scope}();
        }
        if (in_array(SoftDeletes::class, class_uses($model)) && auth()->user()->can('delete', $model)) {
            if (Arr::get($data, 'showSoftDeleted', false)) {
                $query = $query->withTrashed();
            }
        }

        return $query;
    }

    /**
     * @param array $data
     * @param $slug
     * @param $filedSet
     * @param Model $model
     *
     * @return Model
     */
    public function insertOrUpdate(array $data, $slug, $filedSet, $model)
    {
        foreach ($filedSet as $key => $field) {
            if (!$field->persist) {
                continue;
            }
            $content = $this->getContentBasedOnType($data, $slug, $field, $model);
            $model->{$field->name} = $content;
        }

        $model->save();

        return $model;
    }

    public function getContentBasedOnType(array $data, $slug, $field, $model)
    {
        switch ($field->type) {
            case 'password':
                return (new Password($data, $slug, $field, $model))->handle();
            default:
                return (new Text($data, $slug, $field, $model))->handle();
        }
    }
}
