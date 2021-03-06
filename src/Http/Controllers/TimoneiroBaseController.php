<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Contracts\View\Factory;
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
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dataType = $request->getDataType();

        /** @var Model $model */
        $model = app($dataType->model_name);
        $request->check('browse');
        $search = $request->get('s');

        $dataType->removeRelationshipFields();

        $data = $this->getService($dataType)->findAll($search, $request->all());

        $orderBy = request('sort.column', null);
        $sortOrder = request('sort.direction', null);

        $useSoftDeletes = false;
        $showSoftDeleted = false;

        if (in_array(SoftDeletes::class, class_uses($model)) && auth()->user()->can('delete', $model)) {
            $useSoftDeletes = true;
            if ($request->get('showSoftDeleted')) {
                $showSoftDeleted = true;
            }
        }

        $perPage = $data->perPage();
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

    /**
     * @param Request $request
     * @param $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $dataType = $request->getDataType();

        /** @var Model $model */
        $model = app($dataType->model_name);
        foreach ($dataType->scopes as $scope) {
            $model = $model->{$scope}();
        }

        $dataType->removeRelationshipFields('edit');
        $data = $this->getService($dataType)->find($id);

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
     * @throws \Illuminate\Validation\ValidationException
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

        $data = $this->getService($dataType)->find($id);
        $request->check('edit', $data);
        $this->getService($dataType)->update($data, $request->all());

        Timoneiro::pushNotification("Successfully Updated $dataType->display_name_singular");

        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $dataType = $request->getDataType();

        $dataType->removeRelationshipFields('create');
        /** @var Model $data */
        $data = $this->getService($dataType)->getModel();

        $request->check('add', $data);
        $view = 'timoneiro::_models.edit-add';
        if (view()->exists("timoneiro::{$dataType->slug}.edit-add")) {
            $view = "timoneiro::{$dataType->slug}.edit-add";
        }

        return Timoneiro::view($view, compact('dataType', 'data'));
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dataType = $request->getDataType();

        $request->check('add');
        $this->getService($dataType)->create($request->all());

        Timoneiro::pushNotification("Successfully Created $dataType->display_name_singular");

        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $dataType = $request->getDataType();
        $service = $this->getService($dataType);
        $request->check('delete', $service->getModel());
        $ids = [];

        $displayName = count($ids) > 1 ? $dataType->display_name_plural : $dataType->display_name_singular;

        if (empty($id)) {
            $ids = explode(',', $request->ids);
        } else {
            $ids[] = $id;
        }

        try {
            $service->destroy($ids);
            Timoneiro::pushNotification("Successfully deleted {$displayName}");
        } catch (\Exception $e) {
            Timoneiro::pushNotification("Sorry it appears there was a problem deleting this {$displayName}", null, 'error');
        }

        return redirect()->route("timoneiro.{$dataType->slug}.index");
    }
}
