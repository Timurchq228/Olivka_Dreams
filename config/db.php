<?php
$host = '127.0.0.1';
$port = '3306';
$dbname = 'olivka_db';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
