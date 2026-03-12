<?php

namespace App\DTO;

class ServerInfoDTO
{
    public readonly string $phpVersion;
    public readonly string $phpExtensions;
    public readonly string $serverSoftware;

    public function __construct(
        string $phpVersion,
        string $phpExtensions,
        string $serverSoftware
    ) {
        $this->phpVersion = $phpVersion;
        $this->phpExtensions = $phpExtensions;
        $this->serverSoftware = $serverSoftware;
    }

    public function toArray(): array
    {
        return [
            'php_version' => $this->phpVersion,
            'php_extensions' => $this->phpExtensions,
            'server_software' => $this->serverSoftware,
        ];
    }
}