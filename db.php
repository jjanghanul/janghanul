<?php
declare(strict_types=1);

function getDbConnection(): PDO
{
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '3306';
    $socket = getenv('DB_SOCKET') ?: '';
    $name = getenv('DB_NAME') ?: 'janghanul';
    $user = getenv('DB_USER') ?: 'janghanul_user';
    $pass = getenv('DB_PASS') ?: 'janghanul_password';

    if (!in_array('mysql', PDO::getAvailableDrivers(), true)) {
        throw new RuntimeException('PHP mysql 드라이버(PDO MySQL)가 설치되지 않았습니다. `php-mysql` 패키지를 설치해 주세요.');
    }

    if ($socket !== '') {
        $dsn = sprintf('mysql:unix_socket=%s;dbname=%s;charset=utf8mb4', $socket, $name);
    } else {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);
    }

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
