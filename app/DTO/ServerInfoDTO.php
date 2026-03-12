<?php

namespace App\DTO;

class ServerInfoDTO
{
    public readonly string $phpVersion;
    public readonly string $phpExtensions;
    public readonly string $serverSoftware;

    public function __construct(
        ?string $phpVersion = null,
        ?string $phpExtensions = null,
        ?string $serverSoftware = null
    ) {
        $this->phpVersion = $this->sanitizePhpVersion($phpVersion ?? '');
        $this->phpExtensions = $this->sanitizePhpExtensions($phpExtensions ?? '');
        $this->serverSoftware = $this->sanitizeServerSoftware($serverSoftware ?? '');
    }

    private function sanitizePhpVersion(string $version): string
    {
        $version = trim($version);
        
        if (empty($version)) {
            return 'Неизвестно';
        }

        if (strlen($version) > 50) {
            $version = substr($version, 0, 50);
        }
      
        $version = strip_tags($version);
        $version = preg_replace('/[^\w\.\-\s]/u', '', $version);

        if (empty($version)) {
            return 'Неизвестно';
        }
        
        return $version;
    }

    private function sanitizePhpExtensions(string $extensions): string
    {
        $extensions = trim($extensions);
        
        if (empty($extensions)) {
            return 'Неизвестно';
        }
       
        if (strlen($extensions) > 2000) {
            $extensions = substr($extensions, 0, 2000) . '...';
        }

        $extensions = strip_tags($extensions);
        $extensions = preg_replace('/[^\w\,\-\s]/u', '', $extensions);

        if (empty($extensions)) {
            return 'Неизвестно';
        }
        
        return $extensions;
    }

    private function sanitizeServerSoftware(string $software): string
    {
        $software = trim($software);
        
        if (empty($software)) {
            return 'Неизвестно';
        }

        if (strlen($software) > 200) {
            $software = substr($software, 0, 200) . '...';
        }

        $software = strip_tags($software);
        $software = preg_replace('/[^\w\.\-\s\/]/u', '', $software);

        if (empty($software)) {
            return 'Неизвестно';
        }
        
        return $software;
    }

    public function toArray(): array
    {
        return [
            'php_version' => $this->phpVersion,
            'php_extensions' => $this->phpExtensions,
            'server_software' => $this->serverSoftware,
        ];
    }

    public static function fromServer(): self
    {
        return new self(
            phpVersion: phpversion(),
            phpExtensions: implode(', ', get_loaded_extensions()),
            serverSoftware: $_SERVER['SERVER_SOFTWARE'] ?? ''
        );
    }
}