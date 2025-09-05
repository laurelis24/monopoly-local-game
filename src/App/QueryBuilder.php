<?php

namespace App;

use App\Database\DB;
use PDO;

class QueryBuilder {
    // private PDO $pdo;
    private string $table;

    private array $selects = ['*'];
    private $whereParams = [];
    private $joins = [];
    private int $limit = 0;

    public function __construct(string $table) {
        // $this->pdo = DB::getInstance()->getConnection();
        $this->table = $table;
    }

    public function select(array $columns): self {
        $this->selects = $columns;
        return $this;
    }

    public function where(string $first, string $operator, string|int $second): self {
        $this->whereParams[] = [$first, $operator, "'$second'"];
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second): self {
        $this->joins[] = "JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }

    public function and(string $first, string $operator, string $second): self {
        $this->whereParams[] = "AND $first $operator $second";
        return $this;
    }
    public function or(string $first, string $operator, string $second): self {
        $this->whereParams[] = "OR $first $operator $second";
        return $this;
    }

    public function limit(int $count) {
        $this->limit = $count;
        return $this;
    }

    private function buildReadQuery() {
        $selects = join(', ', $this->selects);
        $wheres = join(' ', array_map(function ($val) {
            return gettype($val) === 'array' ? join(' ', $val) : $val;
        }, $this->whereParams));



        $getQuery = "SELECT $selects FROM $this->table ";
        $whereQuery =  count($this->whereParams) ? "WHERE $wheres" : '';
        $joinQuery = count($this->joins) ? join(' ', $this->joins) : '';
        $limitQuery = $this->limit ? "LIMIT $this->limit" : '';

        return $getQuery . $joinQuery . $whereQuery . $limitQuery . ';';
    }


    public function buildCreateQuery(array $params) {
        $columns = [];
        $params = [];
        foreach ($params as $key => $_) {
            $columns[] = $key;
            $params[] = ":$key";
        }
        $joinedColumns = $columns.join(', ', $columns);
        $joinedParams = $params.join(', ', $params);
        return "INSERT INTO $this->table ($joinedColumns) VALUES ($joinedParams)";
    }

    public function get() {
        $sql = $this->buildReadQuery();
        // $stmt = $this->pdo->prepare($sql);
        //  $stmt->execute();
        //   return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        return $this->buildCreateQuery($data);
    }

}
