<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 10/1/19
 * Time: 6:10 PM
 */

namespace Isneezy\Timoneiro\Http\Controllers\ContentTypes;


use Illuminate\Http\Request;
use Isneezy\Timoneiro\DataType\DataTypeField;

abstract class BaseType
{
    /**
     * @var Request
     */
    protected $request;
    protected $slug;
    /**
     * @var DataTypeField
     */
    protected $field;

    public function __construct(Request $request, $slug, $field)
    {
        $this->request = $request;
        $this->slug = $slug;
        $this->field = $field;
    }

    abstract public function handle();
}
