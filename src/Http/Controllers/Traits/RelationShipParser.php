<?php
namespace Isneezy\Timoneiro\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Isneezy\Timoneiro\DataType\AbstractDataType;
use Isneezy\Timoneiro\DataType\DataType;
use ReflectionClass;
use Throwable;

trait RelationShipParser
{
    private function getBlacklistedMethods() {
        return get_class_methods(Model::class);
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     * @param DataType $dataType
     * @param null $model
     * @return array
     */
    public function getRelations(AbstractDataType $dataType, $model = null) {
        if (!$model){
            $model = app($dataType->model_name);
        }
        $relations = [];

        /** @noinspection PhpUnhandledExceptionInspection */
        $reflector = new ReflectionClass($dataType->model_name);

        foreach ($reflector->getMethods() as $method) {
            if (
                $method->isPublic()
                && !$method->getNumberOfParameters()
                && !in_array($method->name, $this->getBlacklistedMethods())
            ) {
                try{
                    $instance = app()->call([$model, $method->name]);
                    if ($instance instanceof BelongsTo) {
                        $type = class_basename($instance);
                        $column = $instance->getForeignKeyName();
                        $related_column = $instance->getOwnerKeyName();
                        $name = $method->name;
                        $related = $instance->getRelated();

                        $relations[$column] = compact(
                            'type',
                            'foreign_key',
                            'column',
                            'related_column',
                            'name',
                            'related'
                        );
                    }
                } catch (Throwable $e) {
                    if ($e instanceof \ReflectionException) {
                        /** @noinspection PhpUnhandledExceptionInspection */
                        throw $e;
                    }
                    // do nothing has we are only testing if we can gate instance of relation
                }
            }
        }

        return $relations;
    }
}
