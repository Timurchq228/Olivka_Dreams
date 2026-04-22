<?php
session_start();
require_once __DIR__ . '/../config/db.php';
if (!empty($_SESSION['customer_id'])) {
    header('Location: profile.php');
    exit;
}
$error='';
$success='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name === '' || $email === '' || $phone === '' || $password === '') {
        $error = 'Заполните все поля';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM customers WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Пользователь с таким email уже существует';
        } else {
            $stmt = $pdo->prepare('INSERT INTO customers (name, email, phone, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, $phone, password_hash($password, PASSWORD_DEFAULT)]);
            $success = 'Регистрация завершена. Теперь войдите в личный кабинет.';
        }
    }
}
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Регистрация клиента</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head><body class="panel-body"><div class="panel-auth-shell"><div class="panel-auth-card"><div class="brand-chip">Olivka_Dreams</div><h1 class="panel-title" style="font-size:38px;margin-top:16px">Создать аккаунт клиента</h1><?php if ($error): ?><div class="panel-alert panel-alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?><?php if ($success): ?><div class="panel-alert panel-alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
<form method="post">
<label class="panel-field"><span class="panel-label">Имя</span><input class="panel-input" name="name" required></label>
<label class="panel-field"><span class="panel-label">Email</span><input class="panel-input" type="email" name="email" required></label>
<label class="panel-field"><span class="panel-label">Телефон</span><input class="panel-input" name="phone" required></label>
<label class="panel-field"><span class="panel-label">Пароль</span><input class="panel-input" type="password" name="password" required></label>
<div class="panel-actions" style="margin-top:10px">
<button class="btn btn-primary" type="submit">Зарегистрироваться</button>
<a class="btn btn-secondary" href="login.php">Войти</a>
<a class="btn btn-secondary" href="../index.php">На сайт</a>
</div>
</form>
<div class="panel-links">После регистрации можно оформлять заказы быстрее и видеть их в личном кабинете.</div></div></div></body></html>