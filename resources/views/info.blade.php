<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        h1 { color: #333; }
        .info-item { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .label { font-weight: bold; color: #555; }
        .value { color: #000; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="/info/server"> Сервер</a>
        <a href="/info/client"> Клиент</a>
        <a href="/info/database">База данных</a>
    </div>

    <h1>{{ $title }}</h1>

    @if(isset($php_version))
        <div class="info-item"><span class="label">Версия PHP:</span> <span class="value">{{ $php_version }}</span></div>
        <div class="info-item"><span class="label">Расширения:</span> <span class="value">{{ $php_extensions }}</span></div>
        <div class="info-item"><span class="label">Сервер:</span> <span class="value">{{ $server_software }}</span></div>
    @endif

    @if(isset($ip_address))
        <div class="info-item"><span class="label">IP-адрес:</span> <span class="value">{{ $ip_address }}</span></div>
    @endif

    @if(isset($driver))
        <div class="info-item"><span class="label">Драйвер:</span> <span class="value">{{ $driver }}</span></div>
        <div class="info-item"><span class="label">Версия БД:</span> <span class="value">{{ $db_version }}</span></div>
        <div class="info-item"><span class="label">Имя базы:</span> <span class="value">{{ $db_name }}</span></div>
    @endif
</body>
</html>