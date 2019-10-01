<?php

namespace Isneezy\Timoneiro\Http\Controllers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Isneezy\Timoneiro\Actions\AbstractAction;
use Isneezy\Timoneiro\Database\DatabaseSchemaManager;
use Isneezy\Timoneiro\Timoneiro;

class TimoneiroBaseController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Timoneiro::dataType($slug);

        /** @var Model $model */
        $model = app($dataType->model_name);
        // Todo check for permission
        // $this->authorize('browse', app($dataType->model_name));
        $search = $request->get('s');


        $query = $model->newQuery();

        if ($search) {
            $searchable = array_keys(DatabaseSchemaManager::describeTable($model->getTable())->toArray());
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
        if (view()->exists("timoneiro::$slug.index")) {
            $view = "timoneiro::$slug.index";
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

    public function edit(Request $request, $id) {
        $slug = $this->getSlug($request);
        $dataType = Timoneiro::dataType($slug);

        /** @var Model $model */
        $model = app($dataType->model_name);
        foreach ($dataType->scopes as $scope) {
            $model = $model->{$scope}();
        }

        $data = $model->findOrFail($id);

        // foreach ($dataType->field_set) {}
        // todo check permissions

        $view = 'timoneiro::_models.edit-add';

        if (view()->exists("timoneiro::$slug.edit-add")) {
            $view = "timoneiro::$slug.edit-add";
        }

        return Timoneiro::view($view, compact('dataType', 'data'));
    }

    public function update(Request $request, $id) {
        $slug = $this->getSlug($request);

        $dataType = Timoneiro::dataType($slug);
        /** @var Model $model */
        $model = app($dataType->model_name);

        foreach ($dataType->scopes as $scope) {
            $model = $model->{$scope}();
        }

        /** @var Model $data */
        $data = $model->findOrFail($id);

        // todo Check permission
        // todo validate fields
        $this->insertOrUpdateData($request, $dataType->slug, $dataType->field_set, $data);
        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }

    public function create(Request $request) {
        $slug = $this->getSlug($request);
        $dataType = Timoneiro::dataType($slug);

        $data = app($dataType->model_name);

        // todo check permission
        $view = 'timoneiro::_models.edit-add';
        if (view()->exists("timoneiro::{$slug}.edit-add")){
            $view = "timoneiro::{$slug}.edit-add";
        }

        return Timoneiro::view($view, compact('dataType', 'data'));
    }

    public function store(Request $request) {
        $slug = $this->getSlug($request);
        $dataType = Timoneiro::dataType($slug);

        // todo Check permission

        // todo Validate
        $this->insertOrUpdateData($request, $slug, $dataType->field_set, app($dataType->model_name));

        return redirect()->route("timoneiro.{$slug}.index");
    }
}
