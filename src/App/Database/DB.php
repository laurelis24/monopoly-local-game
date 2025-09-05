<?php

namespace App\Database;

use App\QueryBuilder;
use PDO;
use PDOException;
use RuntimeException;

class DB {
    private static ?DB $instance = null;
    private ?PDO $pdo = null;
    private string $dbName;
    private string $driver;
    private string $host;
    private string $user;
    private string $password;

    private array $tables = [];

    public function __construct() {
        $this->driver = $_ENV['DATABASE_DRIVER'] ?? 'mysql';
        $this->host = $_ENV['DATABASE_HOST'] ?? '127.0.0.1';
        $this->dbName = $_ENV['DATABASE_NAME'] ?? 'my_app';
        $this->user = $_ENV['DATABASE_USER'] ?? 'root';
        $this->password = $_ENV['DATABASE_PASSWORD'] ?? '';

        try {
            $this->connectToDatabase();
        } catch (\PDOException $e) {
            $this->connectToServer();
        }
    }

    private function connectToServer(): void {
        $dsn = "{$this->driver}:host={$this->host}";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new RuntimeException('Connection to server failed: ' . $e->getMessage());
        }

    }

    public function connectToDatabase(): void {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName}";

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new RuntimeException('Connection to database failed: ' . $e->getMessage());
        }

    }

    public function createDatabase(): void {
        try {
            $this->connectToServer();
            $this->pdo->exec("DROP DATABASE IF EXISTS `{$this->dbName}`");
            $sql = "CREATE DATABASE IF NOT EXISTS `{$this->dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $this->pdo->exec($sql);
            $this->connectToDatabase();
        } catch (PDOException $e) {
            throw new RuntimeException('Create database failed: ' . $e->getMessage());
        }
    }

    public function createTable(string $name, string $columns) {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS {$name} (
                    {$columns})";

            $this->pdo->exec($sql);

            array_push($this->tables, $name);
        } catch (PDOException $e) {
            throw new RuntimeException('Create table failed: ' . $e->getMessage());
        }
    }

    public function insertInto(string $table, array $params) {
        $qBuilder = new QueryBuilder($table);
        $sql = $qBuilder->buildCreateQuery($params);

        try {
            $stmp = $this->pdo->prepare($sql);
            $stmp->execute($params);
        } catch (PDOException $e) {
            throw new RuntimeException('Failed to insert data: ' . $e->getMessage());
        }

    }

    public static function getInstance(): DB {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public function getDbName(): string {
        return $this->dbName;
    }
    public function getTablesName(): array {
        return $this->tables;
    }

    public function __destruct() {
        $this->pdo = null;
    }
}
