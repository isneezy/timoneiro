<?php

namespace Isneezy\Timoneiro\DataType;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceInterface
{
    /**
     * @param string $keyword
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function findAll($keyword = '', array $data = []);

    /**
     * @param $id
     * @return Model | null
     */
    public function find($id);

    /**
     * @param $model
     * @param array $data
     * @return Model
     */
    public function update($model, array $data);

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data);

    /**
     * @return AbstractDataType
     */
    public function getDataType();

    /**
     * @return Model
     */
    public function getModel();

    /**
     * @param array $data
     * @return Builder
     */
    public function newQuery($data = []);
}