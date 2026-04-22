<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin_auth();
require_once __DIR__ . '/../config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO products (title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->execute([
        trim($_POST['title'] ?? ''),
        trim($_POST['short_description'] ?? ''),
        trim($_POST['description'] ?? ''),
        (int)($_POST['price'] ?? 0),
        trim($_POST['image'] ?? ''),
        trim($_POST['badge'] ?? ''),
        trim($_POST['sizes_text'] ?? ''),
        trim($_POST['status_text'] ?? 'В наличии'),
        trim($_POST['features'] ?? '')
    ]);
    header('Location: dashboard.php');
    exit;
}
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Добавить товар</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head><body class="panel-body"><div class="panel-shell"><div class="panel-topbar"><div><div class="brand-chip">Админ-панель</div><h1 class="panel-title" style="margin-top:14px">Новый товар</h1></div><div class="panel-actions"><a class="btn btn-secondary" href="dashboard.php">Назад к товарам</a></div></div><div class="panel-card"><form method="post"><div class="panel-grid"><label class="panel-field"><span class="panel-label">Название</span><input class="panel-input" name="title" required></label><label class="panel-field"><span class="panel-label">Цена</span><input class="panel-input" name="price" type="number" min="0" required></label><label class="panel-field"><span class="panel-label">Файл изображения</span><input class="panel-input" name="image" placeholder="пример.jpg"></label><label class="panel-field"><span class="panel-label">Подпись на фото</span><input class="panel-input" name="badge"></label><label class="panel-field"><span class="panel-label">Краткое описание</span><textarea class="panel-textarea" name="short_description"></textarea></label><label class="panel-field"><span class="panel-label">Размеры / цвета</span><input class="panel-input" name="sizes_text"></label><label class="panel-field"><span class="panel-label">Статус</span><input class="panel-input" name="status_text" value="В наличии"></label></div><label class="panel-field"><span class="panel-label">Полное описание</span><textarea class="panel-textarea" name="description"></textarea></label><label class="panel-field"><span class="panel-label">Особенности (каждая с новой строки)</span><textarea class="panel-textarea" name="features"></textarea></label><div class="panel-actions"><button class="btn btn-primary" type="submit">Сохранить товар</button><a class="btn btn-secondary" href="dashboard.php">Назад</a></div></form></div></div></body></html>