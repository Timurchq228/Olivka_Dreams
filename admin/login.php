<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Неверный логин или пароль';
}
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Админ-панель</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head><body class="panel-body"><div class="panel-auth-shell"><div class="panel-auth-card"><div class="brand-chip">Olivka_Dreams</div><h1 class="panel-title" style="font-size:38px;margin-top:16px">Вход в админ-панель</h1><?php if ($error): ?><div class="panel-alert panel-alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post">
<label class="panel-field"><span class="panel-label">Логин</span><input class="panel-input" name="username" required></label>
<label class="panel-field"><span class="panel-label">Пароль</span><input class="panel-input" type="password" name="password" required></label>
<div class="panel-actions" style="margin-top:10px">
<button class="btn btn-primary" type="submit">Войти</button>
<a class="btn btn-secondary" href="../index.php">На сайт</a>
</div>
</form>
</div></div></body></html>