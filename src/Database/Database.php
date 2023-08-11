<?php

namespace App\Database;

use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery(string $query): bool
    {
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new DatabaseException("Error executing query: " . $e->getMessage());
        }
    }

    public function fetchAll(string $query): array
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseException("Error fetching data: " . $e->getMessage());
        }
    }

    /**
     * @throws DatabaseException
     */
    public function query(): false|array
    {
        $stmt = $this->executeQuery("
            SELECT
                MINUTE(created_at) AS minute,
                COUNT(*) AS num_rows,
                AVG(length) AS avg_length,
                MIN(created_at) AS first_message_time,
                MAX(created_at) AS last_message_time
            FROM content_lengths
            GROUP BY minute
        ");

        return $this->fetchAll($stmt);
    }

    public function save($url, $contentLength): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO content_lengths (url, length, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$url, $contentLength]);
    }
}