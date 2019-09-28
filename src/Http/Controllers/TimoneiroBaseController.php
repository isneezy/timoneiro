<?php

namespace Isneezy\Timoneiro\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
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
        $searchNames = [];
        $searchable = array_keys(DatabaseSchemaManager::describeTable($model->getTable())->toArray());
        foreach ($searchable as $value) {
            $searchNames[$value] = null ?: ucwords(str_replace('_', ' ', $value));
        }

        $query = $model->newQuery();
        foreach ($dataType->scopes as $scope) {
            $query->{$scope}();
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

        $data = $query->paginate();
        $data->defaultView('timoneiro::pagination');

        $view = 'timoneiro::_models.index';
        if (view()->exists("timoneiro::$slug.index")) {
            $view = "timoneiro::$slug.index";
        }

        $viewData = compact(
            'dataType',
            'data',
            'useSoftDeletes',
            'showSoftDeleted'
        );

        if ($request->wantsJson()) {
            return response()->json($viewData);
        }

        return Timoneiro::view($view, $viewData);
    }
}
