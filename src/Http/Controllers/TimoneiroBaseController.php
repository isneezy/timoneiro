<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Isneezy\Timoneiro\Actions\AbstractAction;
use Isneezy\Timoneiro\Facades\Timoneiro;
use Isneezy\Timoneiro\Http\Request;

class TimoneiroBaseController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dataType = $request->getDataType();

        /** @var Model $model */
        $model = app($dataType->model_name);
        $request->check('index');
        $search = $request->get('s');

        $dataType->removeRelationshipFields();
        $query = $model->query();

        if ($search) {
            $searchable = array_keys($dataType->field_set);
            $query->where(function (Builder $query) use ($search, $searchable) {
                foreach ($searchable as $column) {
                    $query->orWhere($column, 'LIKE', "%$search%");
                }
            });
        }

        foreach ($dataType->scopes as $scope) {
            $query->{$scope}();
        }

        $orderBy = request('sort.column', null);
        $sortOrder = request('sort.direction', null);

        if ($orderBy && $sortOrder) {
            $query->orderBy($orderBy, $sortOrder);
        }

        $useSoftDeletes = false;
        $showSoftDeleted = false;

        if (in_array(SoftDeletes::class, class_uses($model)) && auth()->user()->can('delete', $model)) {
            $useSoftDeletes = true;
            if ($request->get('showSoftDeleted')) {
                $showSoftDeleted = true;
                $query = $query->withTrashed();
            }
        }

        $perPage = $request->get('limit', 10);
        $data = $query->paginate($perPage);
        $data->defaultView('timoneiro::pagination');

        // Actions
        $actions = [];
        if (!empty($data->first())) {
            foreach (Timoneiro::actions() as $action) {
                /** @var AbstractAction $action */
                $action = new $action($dataType, $data->first());
                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        $view = 'timoneiro::_models.index';
        if (view()->exists("timoneiro::{$dataType->slug}.index")) {
            $view = "timoneiro::{$dataType->slug}.index";
        }

        $viewData = compact(
            'actions',
            'dataType',
            'data',
            'orderBy',
            'sortOrder',
            'useSoftDeletes',
            'showSoftDeleted',
            'perPage'
        );

        return Timoneiro::view($view, $viewData);
    }

    public function edit(Request $request, $id)
    {
        $dataType = $request->getDataType();

        /** @var Model $model */
        $model = app($dataType->model_name);
        foreach ($dataType->scopes as $scope) {
            $model = $model->{$scope}();
        }

        $dataType->removeRelationshipFields('edit');
        $data = $model->findOrFail($id);

        $request->check('edit', $data);

        $view = 'timoneiro::_models.edit-add';

        if (view()->exists("timoneiro::{$dataType->slug}.edit-add")) {
            $view = "timoneiro::{$dataType->slug}.edit-add";
        }

        return Timoneiro::view($view, compact('dataType', 'data'));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $dataType = $request->getDataType();
        /** @var Model $model */
        $model = app($dataType->model_name);

        foreach ($dataType->scopes as $scope) {
            $model = $model->{$scope}();
        }

        /** @var Model $data */
        $data = $model->findOrFail($id);

        $request->check('edit', $data);
        $this->insertOrUpdateData($request, $dataType->slug, $dataType->field_set, $data);

        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }

    public function create(Request $request)
    {
        $dataType = $request->getDataType();

        $dataType->removeRelationshipFields('create');
        /** @var Model $data */
        $data = app($dataType->model_name);

        $request->check('create', $data);
        $view = 'timoneiro::_models.edit-add';
        if (view()->exists("timoneiro::{$dataType->slug}.edit-add")) {
            $view = "timoneiro::{$dataType->slug}.edit-add";
        }

        return Timoneiro::view($view, compact('dataType', 'data'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dataType = $request->getDataType();

        $request->check('create');
        $this->insertOrUpdateData($request, $dataType->slug, $dataType->field_set, app($dataType->model_name));

        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }
}
