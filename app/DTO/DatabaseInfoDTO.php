<?php

namespace App\DTO;

class DatabaseInfoDTO
{
    public readonly string $driver;
    public readonly string $dbVersion;
    public readonly string $dbName;

    public function __construct(
        string $driver,
        string $dbVersion,
        string $dbName
    ) {
        $this->driver = $driver;
        $this->dbVersion = $dbVersion;
        $this->dbName = $dbName;
    }

    public function toArray(): array
    {
        return [
            'driver' => $this->driver,
            'db_version' => $this->dbVersion,
            'db_name' => $this->dbName,
        ];
    }
}