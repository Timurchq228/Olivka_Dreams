<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/db.php';
$telegram = require __DIR__ . '/../config/telegram.php';

$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);

if (!$input || !is_array($input)) {
    echo json_encode([
        'success' => false,
        'message' => 'Нет данных для оформления заказа'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/*
Поддержка двух форматов:
1) customer
2) customerInfo
*/
$customer = $input['customer'] ?? ($input['customerInfo'] ?? []);
$items = $input['items'] ?? [];

if (empty($items) || !is_array($items)) {
    echo json_encode([
        'success' => false,
        'message' => 'Корзина пуста'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$customerId = $_SESSION['customer_id'] ?? null;

$customerName = trim($customer['name'] ?? '');
$customerPhone = trim($customer['phone'] ?? '');
$address = trim($customer['address'] ?? '');
$commentText = trim($customer['comment'] ?? '');

/*
Поддержка нескольких названий полей доставки
*/
$deliveryType = trim(
    $input['delivery']
    ?? $input['deliveryType']
    ?? ($customer['deliveryType'] ?? 'Самовывоз')
);

$deliveryMethod = trim(
    $input['delivery_method']
    ?? $input['deliveryMethod']
    ?? $deliveryType
);

/*
Если адрес пустой, но это самовывоз, можно взять строку адреса из customerInfo/address
или оставить как есть
*/
if ($address === '' && !empty($customer['pickupAddress'])) {
    $address = trim($customer['pickupAddress']);
}

$subtotal = (int)($input['subtotal'] ?? 0);
$deliveryCost = (int)($input['deliveryCost'] ?? 0);
$grandTotal = (int)($input['grandTotal'] ?? 0);

/*
Если subtotal/grandTotal не пришли, считаем сами
*/
if ($subtotal <= 0) {
    foreach ($items as $item) {
        $itemPrice = (int)($item['price'] ?? 0);
        $itemQty = (int)($item['quantity'] ?? 1);
        $subtotal += $itemPrice * $itemQty;
    }
}

if ($grandTotal <= 0) {
    $grandTotal = $subtotal + $deliveryCost;
}

$orderCode = 'OD' . date('ymdHis') . rand(100, 999);
$itemsJson = json_encode($items, JSON_UNESCAPED_UNICODE);

try {
    $stmt = $pdo->prepare("
        INSERT INTO orders (
            order_code,
            customer_name,
            customer_phone,
            delivery_type,
            address,
            comment_text,
            items_json,
            subtotal,
            delivery_cost,
            grand_total,
            customer_id,
            delivery_method
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $orderCode,
        $customerName,
        $customerPhone,
        $deliveryType,
        $address,
        $commentText,
        $itemsJson,
        $subtotal,
        $deliveryCost,
        $grandTotal,
        $customerId,
        $deliveryMethod
    ]);

    if (!empty($telegram['bot_token']) && !empty($telegram['chat_id'])) {
        $lines = [];
        $lines[] = "🛒 Новый заказ #{$orderCode}";
        $lines[] = "";
        $lines[] = "👤 Клиент: " . ($customerName !== '' ? $customerName : '-');
        $lines[] = "📞 Телефон: " . ($customerPhone !== '' ? $customerPhone : '-');
        $lines[] = "🚚 Способ получения: " . ($deliveryType !== '' ? $deliveryType : '-');
        $lines[] = "📍 Адрес: " . ($address !== '' ? $address : '-');

        if ($commentText !== '') {
            $lines[] = "💬 Комментарий: " . $commentText;
        }

        $lines[] = "";
        $lines[] = "📦 Товары:";

        foreach ($items as $item) {
            $itemName = $item['name'] ?? 'Товар';
            $itemQty = (int)($item['quantity'] ?? 1);
            $itemPrice = (int)($item['price'] ?? 0);
            $lines[] = "— {$itemName} | {$itemQty} x {$itemPrice} ₽";
        }

        $lines[] = "";
        $lines[] = "💰 Товары: {$subtotal} ₽";
        $lines[] = "🚚 Доставка: {$deliveryCost} ₽";
        $lines[] = "✅ Итого: {$grandTotal} ₽";

        $text = implode("\n", $lines);

        @file_get_contents(
            "https://api.telegram.org/bot" . $telegram['bot_token'] . "/sendMessage?" .
            http_build_query([
                'chat_id' => $telegram['chat_id'],
                'text' => $text
            ])
        );
    }

    echo json_encode([
        'success' => true,
        'message' => 'Заказ успешно оформлен',
        'orderId' => $orderCode
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Ошибка при сохранении заказа: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}