<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Isneezy\Timoneiro\DataType\Service;
use Isneezy\Timoneiro\DataType\ServiceInterface;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    /**
     * @param $dataType
     *
     * @return ServiceInterface
     */
    public function getService($dataType): ServiceInterface
    {
        return app($dataType->service ?? Service::class);
    }
}
