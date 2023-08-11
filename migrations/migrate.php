<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Укажите правильный путь к autoload.php

use App\Database\DatabaseFactory;
use App\Database\DatabaseInterface;

// Создаем подключение к базам данных
$databaseFactory = new DatabaseFactory();
$mariaDB = $databaseFactory->createMariaDBDatabase();
$clickHouse = $databaseFactory->createClickHouseDatabase();

// Выполняем миграции для MariaDB
$mariaDB->executeMigration();

// Выполняем миграции для ClickHouse
//$clickHouse->executeMigration();

echo "Migrations completed." . PHP_EOL;
