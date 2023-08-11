<?php

namespace App\RabbitMQ;

interface RabbitMQInterface
{
    public function sendMessage($message);
}