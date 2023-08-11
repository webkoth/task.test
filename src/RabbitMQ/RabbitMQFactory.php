<?php

namespace App\RabbitMQ;

class RabbitMQFactory
{
    public function createRabbitMQ(): RabbitMQInterface
    {
        return new RabbitMQ();
    }
}