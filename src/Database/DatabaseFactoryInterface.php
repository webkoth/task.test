<?php

namespace App\Database;

interface DatabaseFactoryInterface
{
    public function createMariaDBDatabase(): MariaDBDatabase;
    public function createClickHouseDatabase(): ClickHouseDatabase;
}