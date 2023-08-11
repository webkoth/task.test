<?php

namespace App;

use App\Database\DatabaseFactory;
use App\RabbitMQ\RabbitMQ;
use App\RabbitMQ\RabbitMQFactory;

class Main
{
    public function __construct(
        public RabbitMQFactory $rabbitMQFactory,
        public DatabaseFactory $databaseFactory,
    )
    {}

    public function run(): void
    {

        $mariaDBDatabase = $this->databaseFactory->createMariaDBDatabase();
        //$clickHouseDatabase = $this->databaseFactory->createClickHouseDatabase();
        $rabbitMQ = $this->rabbitMQFactory->createRabbitMQ();
        $messageProducer = new MessageProducer($rabbitMQ);

        $urls = [
            'https://example.com/page1',
            'https://example.com/page2',
            'https://example.com/page3',
            'https://example.com/page4',
            'https://example.com/page5',
            'https://example.com/page6',
            'https://example.com/page7',
            'https://example.com/page8',
            'https://example.com/page9',
            'https://example.com/page10',
        ];

        $messageProducer->sendMessages($urls);

        $rabbitMQ->consumeMessages(function ($message) {
            var_dump('str');
            $messageBody = $message->getBody();
            echo "Received message: $messageBody" . PHP_EOL;
        });

    }

    private function getContentLength($url): int
    {
        $content = file_get_contents($url);

        if (!$content) {
            throw new \Exception("Failed to fetch content from URL: $url");
        }
        return strlen($content);
    }
}