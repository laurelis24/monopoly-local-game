<?php

namespace App\Database;

use PDO;

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
        $this->driver   = $_ENV['DATABASE_DRIVER'] ?? 'mysql';
        $this->host     = $_ENV['DATABASE_HOST'] ?? '127.0.0.1';
        $this->dbName   = $_ENV['DATABASE_NAME'] ?? 'my_app';
        $this->user     = $_ENV['DATABASE_USER'] ?? 'root';
        $this->password = $_ENV['DATABASE_PASSWORD'] ?? '';


        try {
            $this->connectToDatabase();
        } catch (\PDOException $e) {
            $this->connectToServer();
        }
    }

    private function connectToServer(): void {
        $dsn = "{$this->driver}:host={$this->host}";
        $this->pdo = new PDO($dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function connectToDatabase(): void {
        $dsn = "{$this->driver}:host={$this->host};dbname={$this->dbName}";
        $this->pdo = new PDO($dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createDatabase(): void {
        try {
            $this->connectToServer();
            $this->pdo->exec("DROP DATABASE IF EXISTS `{$this->dbName}`");
            $sql = "CREATE DATABASE IF NOT EXISTS `{$this->dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $this->pdo->exec($sql);
            $this->connectToDatabase();
        } catch (\Throwable $e) {
            die('DB ERROR (createDatabase): ' . $e->getMessage());
        }
    }


    public function createTable(string $name, string $columns) {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS {$name} (
                    {$columns})";

            $this->pdo->exec($sql);

            array_push($this->tables, $name);
        } catch (\Throwable $e) {
            die('DB ERROR (createTable): ' . $e->getMessage());
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
