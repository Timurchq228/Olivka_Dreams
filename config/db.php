<?php
$host = 'localhost';
$dbname = 'cb878677_olivka';
$username = 'cb878677_olivka';
$password = 'Zagadka.1996';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}