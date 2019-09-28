<?php

namespace Isneezy\Timoneiro\Database;


use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Support\Facades\DB;

class DatabaseSchemaManager
{
    public static function __callStatic($method, $args)
    {
        return static::manager()->$method(...$args);
    }

    /**
     * @return AbstractSchemaManager
     */
    public static function manager() {
        return DB::connection()->getDoctrineSchemaManager();
    }


    /**
     * @param $tableName
     * @return \Illuminate\Support\Collection
     */
    public static function describeTable($tableName) {
        $table = self::manager()->listTableDetails($tableName);
        return collect($table->getColumns())->map(function (Column $column) use ($table) {
            $columnArr = $column->toArray();
            $columnArr['field'] = $columnArr['name'];
            $columnArr['type'] = $column->getType()->getName();

            $columnArr['indexes'] = [];
            $columnArr['key'] = null;

            return $columnArr;
        });
    }
}
