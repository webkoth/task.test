<?php

namespace App\Database;

class MariaDBDatabase extends Database
{
    public function executeMigration(): void
    {
        $createTableQuery = "
            CREATE TABLE content_lengths (
                id INT AUTO_INCREMENT PRIMARY KEY,
                url VARCHAR(255) NOT NULL,
                length INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
        ";

        try {
            $this->pdo->exec($createTableQuery);
            echo "Migration executed for MariaDB." . PHP_EOL;
        } catch (\Exception $e) {
            echo "Migration error: " . $e->getMessage() . PHP_EOL;
        }
    }
}
