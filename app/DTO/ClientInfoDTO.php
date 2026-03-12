<?php

namespace App\DTO;

class ClientInfoDTO
{
    public readonly string $ipAddress;
    public readonly string $userAgent;

    public function __construct(
        ?string $ipAddress = null,
        ?string $userAgent = null
    ) {
        $this->ipAddress = $this->sanitizeIp($ipAddress ?? '');
        $this->userAgent = $this->sanitizeUserAgent($userAgent ?? '');
    }

    private function sanitizeIp(string $ip): string
    {
        $ip = trim($ip);

        if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'Неизвестно';
        }
        
        return $ip;
    }

    private function sanitizeUserAgent(string $userAgent): string
    {
        $userAgent = trim($userAgent);
        
        if (empty($userAgent)) {
            return 'Неизвестно';
        }

        if (strlen($userAgent) > 500) {
            $userAgent = substr($userAgent, 0, 500) . '...';
        }

        $userAgent = strip_tags($userAgent);
        
        return $userAgent;
    }

    public function toArray(): array
    {
        return [
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
        ];
    }

    public static function fromRequest(): self
    {
        return new self(
            ipAddress: request()->ip(),
            userAgent: request()->userAgent()
        );
    }
}