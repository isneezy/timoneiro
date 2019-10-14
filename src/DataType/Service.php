<?php

namespace Isneezy\Timoneiro\DataType;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Service
{
    public function findAll($keyword = '', array $data = [])
    {
        $query = $this->newQuery();
        if ($keyword) {
            $searchable = array_keys($this->getDataType()->field_set);
            $query->where(function (Builder $query) use ($keyword, $searchable) {
                foreach ($searchable as $column) {
                    $query->orWhere($column, 'LIKE', "%$keyword%");
                }
            });
        }

        $orderBy = Arr::get($data, 'sort.column');
        $sortOrder = request('sort.direction');

        if ($orderBy && $sortOrder) {
            $query->orderBy($orderBy, $sortOrder);
        }

        $perPage = Arr::get($data, 'limit', 10);
        return $query->paginate($perPage);
    }

    /**
     * @param $id
     * @return Collection|Model
     */
    public function find($id) {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * @return AbstractDataType
     */
    public function getDataType() {
        return app(AbstractDataType::class);
    }

    /**
     * @return Model
     */
    public function getModel() {
        return app($this->getDataType()->model_name);
    }

    /**
     * @param array $data
     * @return Builder
     */
    public function newQuery($data = []) {

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
}