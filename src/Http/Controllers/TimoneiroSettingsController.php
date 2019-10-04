<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Isneezy\Timoneiro\DataType\DataTypeField;
use Isneezy\Timoneiro\Models\Setting;

class TimoneiroSettingsController extends Controller
{
    public function index(Request $request)
    {
        $groups = array_keys(config('timoneiro.settings', []));
        $active = $request->get('group', Arr::first($groups));
        $settings = $this->getSettings($active);

        $data = $this->queryData($settings);

        return view('timoneiro::settings.index', compact('groups', 'active', 'settings', 'data'));
    }

    public function update(Request $request)
    {
        $active = $request->get('_group');
        $settings = $this->getSettings($active);
        $data = $this->queryData($settings);

        foreach ($settings as $setting) {
            $value = $this->getContentBasedOnType($request, 'settings', $setting);
            $data = $data->get($setting->name);
            $data->value = $value;
            $data->save();
        }

        $redirect = $request->fullUrlWithQuery(['group' => $active]);

        return redirect($redirect);
    }

    public function getSettings($active)
    {
        return collect(config("timoneiro.settings.{$active}"))->map(function (array $def, $name) {
            return $field = new DataTypeField($def + compact('name'));
        })->all();
    }

    public function queryData($settings)
    {
        $data = Setting::query()->whereIn('key', array_keys($settings))->get()->keyBy('key');

        return collect($settings)->map(function ($def, $key) use ($data) {
            $setting = $data->get($key) ?? new Setting();
            $setting->key = $key;

            return $setting;
        });
    }
}
