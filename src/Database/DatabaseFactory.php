<?php

namespace App\Database;

use PDO;


class DatabaseFactory implements DatabaseFactoryInterface
{
    public function createMariaDBDatabase(): MariaDBDatabase
    {
        $mariadbConfig = require __DIR__ . '/../../config/mariadb.php';
        $pdoMariaDB = new PDO("mysql:host={$mariadbConfig['host']};dbname={$mariadbConfig['dbname']}", $mariadbConfig['username'], $mariadbConfig['password']);

        return new MariaDBDatabase($pdoMariaDB);
    }

    public function createClickHouseDatabase(): ClickHouseDatabase
    {
        $clickhouseConfig = require __DIR__ . '/../../config/clickhouse.php';

        $pdoClickHouse = new PDO("clickhouse:host={$clickhouseConfig['host']};dbname={$clickhouseConfig['dbname']}", $clickhouseConfig['username'], $clickhouseConfig['password']);

        return new ClickHouseDatabase($pdoClickHouse);
    }
}