<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin_auth();
require_once __DIR__ . '/../config/db.php';


$products = $pdo->query('SELECT * FROM products ORDER BY id ASC')->fetchAll();
?>
<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Админ-панель</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head>
<body class="panel-body">
    <div class="panel-shell">
        <div class="panel-topbar">
            <div>
                <div class="brand-chip">Админ-панель</div>
                <h1 class="panel-title" style="margin-top:14px">Управление товарами</h1>
                <div class="panel-subtitle">Изменения сразу отображаются на сайте.</div>
            </div>

            <div class="panel-actions">
                <a class="btn btn-secondary" href="../index.php">Открыть сайт</a>
                <a class="btn btn-primary" href="add-product.php">Добавить товар</a>
                <a class="btn btn-danger" href="logout.php">Выйти</a>
            </div>
        </div>

        <div class="panel-card">
            <div class="panel-table-wrap"><table class="panel-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= (int)$product['id'] ?></td>

                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img class="preview" src="../<?= htmlspecialchars($product['image']) ?>" alt="">
                                <?php endif; ?>
                            </td>

                            <td>
                                <strong><?= htmlspecialchars($product['title']) ?></strong>
                                <div class="panel-small" style="margin-top:6px">
                                    <?= htmlspecialchars($product['short_description']) ?>
                                </div>
                            </td>

                            <td><?= number_format((int)$product['price'], 0, '', ' ') ?> ₽</td>

                            <td><?= htmlspecialchars($product['status_text']) ?></td>

                            <td>
                                <a class="btn btn-primary" href="edit-product.php?id=<?= (int)$product['id'] ?>">
                                    Редактировать
                                </a>

                                <form method="POST"
                                      action="delete_product.php"
                                      onsubmit="return confirm('Удалить товар?');"
                                      style="display:inline-block; margin-left:8px;">
                                    <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
                                    <button type="submit" class="btn btn-danger">
                                        🗑 Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table></div>
        </div>
    </div>
</body>
</html>