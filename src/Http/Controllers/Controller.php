<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Isneezy\Timoneiro\Http\Controllers\ContentTypes\Text;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
            $this->slug = $slug;
        }

        return $slug;
    }

    public function insertOrUpdateData($request, $slug, $filedSet, $data)
    {
        foreach ($filedSet as $field) {
            $content = $this->getContentBasedOnType($request, $slug, $field);
            $data->{$field->name} = $content;
        }

        $data->save();

        return $data;
    }

    public function getContentBasedOnType($request, $slug, $field)
    {
        switch ($field->type) {
            default:
                return (new Text($request, $slug, $field))->handle();
        }
    }
}
