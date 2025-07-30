<?php

namespace App\Models;

use App\QueryBuilder;

class Model {
    protected static string $table;

    public static function query(): QueryBuilder {
        return new QueryBuilder(static::$table);
    }

    public static function select(array $columns = ['*']) {
        return static::query()->select($columns);
    }
}
