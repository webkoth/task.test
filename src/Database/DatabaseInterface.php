<?php

namespace App\Database;

interface DatabaseInterface
{
    public function save($url, $contentLength);
    public function query();
}
