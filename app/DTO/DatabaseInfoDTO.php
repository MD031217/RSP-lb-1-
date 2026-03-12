<?php

namespace App\DTO;

class DatabaseInfoDTO
{
    public readonly string $driver;
    public readonly string $dbVersion;
    public readonly string $dbName;

    public function __construct(
        ?string $driver = null,
        ?string $dbVersion = null,
        ?string $dbName = null
    ) {
        $this->driver = $this->sanitizeDriver($driver ?? '');
        $this->dbVersion = $this->sanitizeDbVersion($dbVersion ?? '');
        $this->dbName = $this->sanitizeDbName($dbName ?? '');
    }

    private function sanitizeDriver(string $driver): string
    {
        $driver = trim(strtolower($driver));

        $allowedDrivers = ['mysql', 'pgsql', 'sqlite', 'sqlsrv', 'mariadb'];
        
        if (empty($driver) || !in_array($driver, $allowedDrivers, true)) {
            return 'unknown';
        }
        
        return $driver;
    }

    private function sanitizeDbVersion(string $version): string
    {
        $version = trim($version);
        
        if (empty($version)) {
            return 'Неизвестно';
        }

        if (strlen($version) > 100) {
            $version = substr($version, 0, 100) . '...';
        }

        $version = strip_tags($version);
        $version = preg_replace('/[^\w\.\-\s]/u', '', $version);

        if (empty($version)) {
            return 'Неизвестно';
        }
        
        return $version;
    }

    private function sanitizeDbName(string $dbName): string
    {
        $dbName = trim($dbName);
        
        if (empty($dbName)) {
            return 'Неизвестно';
        }
        
        if (strlen($dbName) > 100) {
            $dbName = substr($dbName, 0, 100) . '...';
        }

        $dbName = strip_tags($dbName);
        $dbName = preg_replace('/[^\w\-]/u', '', $dbName);

        if (empty($dbName)) {
            return 'Неизвестно';
        }
        
        return $dbName;
    }

    public function toArray(): array
    {
        return [
            'driver' => $this->driver,
            'db_version' => $this->dbVersion,
            'db_name' => $this->dbName,
        ];
    }

    public static function fromConfig(): self
    {
        try {
            $dbInfo = \DB::select('SELECT VERSION() as version');
            $version = $dbInfo[0]->version ?? '';
        } catch (\Exception $e) {
            $version = 'Ошибка подключения: ' . $e->getMessage();
        }

        return new self(
            driver: config('database.default'),
            dbVersion: $version,
            dbName: config('database.connections.' . config('database.default') . '.database')
        );
    }
}