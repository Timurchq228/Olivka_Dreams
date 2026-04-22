<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'Заполните все поля';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Такой логин уже существует';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
            $success = 'Пользователь создан. Теперь можно войти.';
        }
    }
}
?><!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Регистрация администратора</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head><body class="panel-body"><div class="panel-auth-shell"><div class="panel-auth-card"><div class="brand-chip">Olivka_Dreams</div><h1 class="panel-title" style="font-size:38px;margin-top:16px">Регистрация администратора</h1><?php if ($error): ?><div class="panel-alert panel-alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="panel-alert panel-alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
<form method="post">
<label class="panel-field"><span class="panel-label">Логин</span><input class="panel-input" name="username" required></label>
<label class="panel-field"><span class="panel-label">Пароль</span><input class="panel-input" type="password" name="password" required></label>
<label class="panel-field"><span class="panel-label">Повтор пароля</span><input class="panel-input" type="password" name="confirm_password" required></label>
<div class="panel-actions" style="margin-top:10px">
<button class="btn btn-primary" type="submit">Создать аккаунт</button>
<a class="btn btn-secondary" href="login.php">Назад ко входу</a>
</div>
</form></div></div></body></html>