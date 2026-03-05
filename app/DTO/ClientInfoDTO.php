<?php

namespace App\DTO;

class ClientInfoDTO
{
    public readonly string $ipAddress;
    public readonly string $userAgent;

    public function __construct(
        string $ipAddress,
        string $userAgent
    ) {
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    public function toArray(): array
    {
        return [
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
        ];
    }
}