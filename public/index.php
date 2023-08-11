<?php
require_once '../vendor/autoload.php';

use App\Main;
use App\RabbitMQ\RabbitMQFactory;
use App\Database\DatabaseFactory;

$rabbitMQFactory = new RabbitMQFactory();


$databaseFactory = new DatabaseFactory();

$main = new Main($rabbitMQFactory, $databaseFactory, );
$main->run();
