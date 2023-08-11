<?php

// app/src/MessageProducer.php

namespace App;

use App\RabbitMQ\RabbitMQInterface;

class MessageProducer
{
    private RabbitMQInterface $rabbitMQ;

    public function __construct(RabbitMQInterface $rabbitMQ)
    {
        $this->rabbitMQ = $rabbitMQ;
    }

    public function sendMessages(array $urls): void
    {
        ini_set('max_execution_time', 200);

        foreach ($urls as $url) {
            $this->rabbitMQ->sendMessage(json_encode(['url' => $url]));
            sleep(rand(5, 30));
        }

        ini_restore('max_execution_time');
    }
}
