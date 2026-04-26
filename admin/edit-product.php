<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin_auth();
require_once __DIR__ . '/../config/db.php';

function save_image($file, $oldImage) {
    if (empty($file['name'])) {
        return $oldImage;
    }
    $name = basename($file['name']);
    $path = __DIR__ . '/../' . $name;
    move_uploaded_file($file['tmp_name'], $path);
    return $name;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    die('Товар не найден');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = save_image($_FILES['image_file'] ?? [], $product['image']);
    $status = $_POST['status_text'] ?? 'В наличии';

    $stmt = $pdo->prepare('UPDATE products SET title=?, short_description=?, description=?, price=?, image=?, badge=?, sizes_text=?, status_text=?, features=? WHERE id=?');
    $stmt->execute([
        trim($_POST['title'] ?? ''),
        trim($_POST['short_description'] ?? ''),
        trim($_POST['description'] ?? ''),
        (int)($_POST['price'] ?? 0),
        $image,
        trim($_POST['badge'] ?? ''),
        trim($_POST['sizes_text'] ?? ''),
        $status,
        trim($_POST['features'] ?? ''),
        $id
    ]);
    header('Location: edit-product.php?id=' . $id . '&saved=1');
    exit;
}
?>
<!doctype html><html lang="ru"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Редактировать товар</title><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="../Style.css"><link rel="stylesheet" href="../assets/panel.css"></head><body class="panel-body"><div class="panel-shell"><div class="panel-topbar"><div><div class="brand-chip">Админ-панель</div><h1 class="panel-title" style="margin-top:14px">Редактирование товара</h1><div class="panel-subtitle">ID: <?= (int)$product['id'] ?></div></div><div class="panel-actions"><a class="btn btn-secondary" href="dashboard.php">Назад к товарам</a></div></div><?php if (!empty($_GET['saved'])): ?><div class="panel-alert panel-alert-success">Изменения сохранены</div><?php endif; ?><div class="panel-card"><form method="post" enctype="multipart/form-data"><div class="panel-grid"><label class="panel-field"><span class="panel-label">Название</span><input class="panel-input" name="title" value="<?= htmlspecialchars($product['title']) ?>" required></label><label class="panel-field"><span class="panel-label">Цена</span><input class="panel-input" name="price" type="number" min="0" value="<?= (int)$product['price'] ?>" required></label><label class="panel-field"><span class="panel-label">Изображение товара</span><input class="panel-input" name="image_file" type="file" accept="image/*"></label><label class="panel-field"><span class="panel-label">Подпись на фото</span><input class="panel-input" name="badge" value="<?= htmlspecialchars($product['badge']) ?>"></label><label class="panel-field"><span class="panel-label">Краткое описание</span><textarea class="panel-textarea" name="short_description"><?= htmlspecialchars($product['short_description']) ?></textarea></label><label class="panel-field"><span class="panel-label">Размеры / цвета</span><input class="panel-input" name="sizes_text" value="<?= htmlspecialchars($product['sizes_text']) ?>"></label><div class="panel-field"><span class="panel-label">Наличие товара</span><div class="radio-row"><label><input type="radio" name="status_text" value="В наличии" <?= $product['status_text'] === 'Нет в наличии' ? '' : 'checked' ?>> В наличии</label><label><input type="radio" name="status_text" value="Нет в наличии" <?= $product['status_text'] === 'Нет в наличии' ? 'checked' : '' ?>> Нет в наличии</label></div></div><?php if ($product['image']): ?><div class="panel-field"><span class="panel-label">Текущее фото</span><img class="preview" src="../<?= htmlspecialchars($product['image']) ?>" alt=""></div><?php endif; ?></div><label class="panel-field"><span class="panel-label">Полное описание</span><textarea class="panel-textarea" name="description"><?= htmlspecialchars($product['description']) ?></textarea></label><label class="panel-field"><span class="panel-label">Особенности</span><textarea class="panel-textarea" name="features"><?= htmlspecialchars($product['features']) ?></textarea></label><div class="panel-actions"><button class="btn btn-primary" type="submit">Сохранить изменения</button><a class="btn btn-secondary" href="dashboard.php">Назад</a></div></form></div></div></body></html>
