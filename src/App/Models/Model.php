<?php

namespace App\Models;

use App\Database\DB;
use App\QueryBuilder;

class Model {
    protected static string $table;

    public static function db(): DB {
        // return new QueryBuilder(static::$table);
        return DB::getInstance();
    }

    public static function select(array $columns = ['*']) {
        // return static::db()->insertInto($columns);
    }

    public static function create(array $data) {
        return static::db()->insertInto(static::$table, $data);
    }
}
