<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller
{
    public function serverInfo()
    {
        return view('info', [
            'title' => 'Информация о сервере',
            'php_version' => phpversion(),
            'php_extensions' => implode(', ', get_loaded_extensions()),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        ]);
    }

    public function clientInfo()
    {
        return view('info', [
            'title' => 'Информация о клиенте',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    public function databaseInfo()
    {
        try {
            $dbInfo = DB::select('SELECT VERSION() as version');
            $version = $dbInfo[0]->version;
            $driver = config('database.default');
            $database = config('database.connections.' . $driver . '.database');
        } catch (\Exception $e) {
            $version = 'Ошибка подключения';
            $driver = config('database.default');
            $database = config('database.connections.' . $driver . '.database');
        }

        return view('info', [
            'title' => 'Информация о базе данных',
            'driver' => $driver,
            'db_version' => $version,
            'db_name' => $database,
        ]);
    }
}
