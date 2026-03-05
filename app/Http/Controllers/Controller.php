<?php

namespace App\Http\Controllers;

use App\DTO\ServerInfoDTO;
use App\DTO\ClientInfoDTO;
use App\DTO\DatabaseInfoDTO;
use App\Http\Request;
use App\Support\Facades\DB;
use App\Http\JsonResponse;

class Controller
{

    public function serverInfo(): JsonResponse
    {
        $dto = new ServerInfoDTO(
            phpversion(),
            implode(', ', get_loaded_extensions()),
            $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
        );

        return response()->json($dto->toArray());
    }

    public function clientInfo(): JsonResponse
    {
        $dto = new ClientInfoDTO(
            request()->ip(),
            request()->userAgent()
        );

        return response()->json($dto->toArray());
    }

    public function databaseInfo(): JsonResponse
    {
        try {
            $dbInfo = DB::select('SELECT VERSION() as version');
            $version = $dbInfo[0]->version ?? 'Неизвестно';
        } catch (\Exception $e) {
            $version = 'Ошибка подключения';
        }

        $dto = new DatabaseInfoDTO(
            config('database.default'),
            $version,
            config('database.connections.' . config('database.default') . '.database')
        );

        return response()->json($dto->toArray());
    }
}
