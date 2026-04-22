<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin_auth();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    die('Неверный ID товара');
}

try {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        header('Location: dashboard.php?deleted=1');
        exit;
    } else {
        die('Товар не найден или уже удалён');
    }
} catch (PDOException $e) {
    die('Ошибка удаления: ' . $e->getMessage());
}