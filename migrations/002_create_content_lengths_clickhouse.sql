-- migrations/002_create_content_lengths_clickhouse.sql

CREATE TABLE content_lengths (
    id Int32,
    url String,
    length Int32,
    created_at DateTime
) ENGINE = MergeTree()
ORDER BY id;