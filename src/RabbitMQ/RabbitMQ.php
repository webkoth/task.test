<?php

namespace App\RabbitMQ;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ implements RabbitMQInterface
{
    private AMQPStreamConnection $connection;
    private AbstractChannel|AMQPChannel $channel;
    private string $queueName = 'rabbit@my_queue';

    public function __construct()
    {
        $rabbitMQConfig = require __DIR__ . '/../../config/rabbitmq.php';
        $this->connection = new AMQPStreamConnection($rabbitMQConfig['host'], $rabbitMQConfig['port'], $rabbitMQConfig['username'], $rabbitMQConfig['password']);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queueName, false, false, false, false);
    }

    public function sendMessage($message): void
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $this->queueName);
    }

    public function consumeMessages($callback): void
    {

        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}