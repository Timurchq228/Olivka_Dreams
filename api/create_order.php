<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/db.php';
$telegram = require __DIR__ . '/../config/telegram.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Нет данных'], JSON_UNESCAPED_UNICODE);
    exit;
}

$customer = $data['customerInfo'] ?? [];
$items = $data['items'] ?? [];

if (!$items) {
    echo json_encode(['success' => false, 'message' => 'Корзина пустая'], JSON_UNESCAPED_UNICODE);
    exit;
}

$name = trim($customer['name'] ?? '');
$phone = trim($customer['phone'] ?? '');
$deliveryType = trim($customer['deliveryType'] ?? 'pickup');
$deliveryLabel = trim($customer['deliveryLabel'] ?? 'Самовывоз');
$address = trim($customer['address'] ?? '');
$comment = trim($customer['comment'] ?? '');
$customerId = $_SESSION['customer_id'] ?? null;

$subtotal = 0;
foreach ($items as $item) {
    $price = (int)($item['price'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 1);
    $subtotal += $price * $quantity;
}

$deliveryCost = (int)($data['deliveryCost'] ?? 0);
$grandTotal = $subtotal + $deliveryCost;
$orderCode = 'OD' . date('ymdHis') . rand(100, 999);
$itemsJson = json_encode($items, JSON_UNESCAPED_UNICODE);

try {
    $stmt = $pdo->prepare('INSERT INTO orders (order_code, customer_id, customer_name, customer_phone, delivery_type, delivery_label, address, comment_text, items_json, subtotal, delivery_cost, grand_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$orderCode, $customerId, $name, $phone, $deliveryType, $deliveryLabel, $address, $comment, $itemsJson, $subtotal, $deliveryCost, $grandTotal]);

    if (!empty($telegram['bot_token']) && !empty($telegram['chat_id'])) {
        $text = "Новый заказ #$orderCode\n\n";
        $text .= "Клиент: " . ($name ?: '-') . "\n";
        $text .= "Телефон: " . ($phone ?: '-') . "\n";
        $text .= "Доставка: " . ($deliveryLabel ?: '-') . "\n";
        $text .= "Адрес: " . ($address ?: '-') . "\n";
        $text .= "Комментарий: " . ($comment ?: '-') . "\n\n";
        $text .= "Товары:\n";

        foreach ($items as $item) {
            $itemName = $item['name'] ?? 'Товар';
            $itemPrice = (int)($item['price'] ?? 0);
            $itemQuantity = (int)($item['quantity'] ?? 1);
            $text .= "$itemName — $itemQuantity шт. x $itemPrice ₽\n";
        }

        $text .= "\nТовары: $subtotal ₽\n";
        $text .= "Доставка: $deliveryCost ₽\n";
        $text .= "Итого: $grandTotal ₽";

        file_get_contents('https://api.telegram.org/bot' . $telegram['bot_token'] . '/sendMessage?' . http_build_query([
            'chat_id' => $telegram['chat_id'],
            'text' => $text
        ]));
    }

    echo json_encode(['success' => true, 'message' => 'Заказ отправлен', 'orderId' => $orderCode], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка сохранения заказа'], JSON_UNESCAPED_UNICODE);
}
