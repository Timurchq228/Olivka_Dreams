<?php
session_start();
require_once __DIR__ . '/config/db.php';
$products = $pdo->query("SELECT * FROM products ORDER BY id ASC")->fetchAll();
$productsJs = [];
foreach ($products as $product) {
    $productsJs[(int)$product['id']] = [
        'name' => $product['title'],
        'price' => (int)$product['price'],
        'image' => $product['image'],
        'description' => $product['description'],
        'features' => $product['features'] !== '' ? preg_split("/\r\n|\r|\n/", $product['features']) : []
    ];
}
$customerLoggedIn = !empty($_SESSION['customer_id']);
$customerName = $_SESSION['customer_name'] ?? '';
$customerPhone = $_SESSION['customer_phone'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olivka_Dreams - Детские товары</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary-color: #4da6ff;
            --secondary-color: #b8e1ff;
            --accent-color: #ffb8d9;
            --season-color: #8ad8ff;
            --text-color: #333;
            --background-color: #f8fcff;
            --card-bg: linear-gradient(135deg, white, #f0f9ff);
            --header-gradient: linear-gradient(135deg, #4da6ff, #8ad8ff);
            --button-gradient: linear-gradient(135deg, #0088cc, #24a1de);
            --season-icon: '❄️';
            --cart-gradient: linear-gradient(135deg, #4da6ff, #24a1de);
            --season-particles: '❄️';
            --season-border: 2px solid #8ad8ff;
            --season-shadow: 0 0 20px rgba(138, 216, 255, 0.3);
        }
        
        body {
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', 'Arial', sans-serif;
            font-weight: 600;
        }
        
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes snowfall {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }
        
        @keyframes leaves-fall {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }
        
        @keyframes sand-fall {
            0% { transform: translateY(-100px) translateX(-50px); opacity: 1; }
            100% { transform: translateY(100vh) translateX(50px); opacity: 0; }
        }
        
        @keyframes blossom-fall {
            0% { transform: translateY(-100px) rotate(0deg) scale(1); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg) scale(0.5); opacity: 0; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes garland {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        
        
        .season-particle {
            position: fixed;
            font-size: 20px;
            z-index: 1;
            pointer-events: none;
            animation-duration: 10s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        
        
        .top {
            background: var(--header-gradient);
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
            border-bottom: var(--season-border);
        }
        
        .header-decoration {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        
        .garland-line {
            position: absolute;
            top: 5px;
            width: 100%;
            height: 20px;
        }
        
        .garland-light {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            box-shadow: 0 0 10px currentColor;
            animation: pulse 2s infinite alternate;
        }
        
        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .logo-frame {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.3), var(--season-shadow);
            border: var(--season-border);
            animation: float 3s ease-in-out infinite;
        }
        
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .title-box {
            flex: 1;
        }
        
        .main-title {
            color: white;
            font-size: 22px;
            margin-bottom: 5px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }
        
        .subtitle {
            color: white;
            opacity: 0.9;
            font-size: 14px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }
        
        .season-indicator {
            display: inline-block;
            margin-left: 10px;
            font-size: 20px;
        }
        
        
        .nav {
            display: flex;
            justify-content: space-around;
            gap: 5px;
            padding-bottom: 5px;
            flex-wrap: nowrap;
            overflow: hidden;
        }
        
        .nav-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 15px;
            border-radius: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            font-size: 14px;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.3);
            flex: 1;
            justify-content: center;
            min-width: 0;
        }
        
        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .cart-btn {
            position: relative;
        }
        
        .cart-count {
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: -5px;
            right: -5px;
        }
        
        
        .welcome {
            background: linear-gradient(135deg, rgba(77, 166, 255, 0.15), rgba(138, 216, 255, 0.1));
            padding: 25px 20px;
            margin: 20px;
            border-radius: 15px;
            border-left: 5px solid var(--primary-color);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .welcome::before {
            content: var(--season-icon);
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 60px;
            opacity: 0.2;
        }
        
        .welcome h2 {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .welcome p {
            font-size: 16px;
            line-height: 1.6;
        }
        
        .about {
            padding: 25px 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--background-color), rgba(138, 216, 255, 0.05));
            margin: 20px;
            border-radius: 20px;
            border: var(--season-border);
            box-shadow: var(--season-shadow);
        }
        
        .about h3 {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .about p {
            font-size: 16px;
            line-height: 1.6;
        }
        
        .products {
            padding: 25px 20px;
        }
        
        .products h3 {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: var(--season-border);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2), var(--season-shadow);
        }
        
        .product-photo {
            width: 100%;
            height: 180px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--season-color));
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            animation: float 2s ease-in-out infinite;
        }
        
        .card h4 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .card p {
            color: #666;
            font-size: 15px;
            margin-bottom: 15px;
            flex: 1;
            line-height: 1.5;
        }
        
        .product-details {
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(255,255,255,0.5);
            border-radius: 12px;
            border: 1px solid rgba(138,216,255,0.3);
        }
        
        .price-tag {
            color: var(--primary-color);
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        
        
        .sizes {
            color: #666;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
      
        
        .product-status {
            margin-bottom: 15px;
        }
        
        .in-stock {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .in-stockk {
            background: linear-gradient(135deg, #ffe1e1, #ffd0d0);
            color: #c62828;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
     
        
        
        .view-details {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            padding: 0;
        }
        
        .view-details:hover {
            color: var(--accent-color);
        }
        
        .add-to-cart-btn {
            background: var(--button-gradient);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        
        
        .product-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .product-modal.show {
            display: flex;
        }
        
        .product-modal-content {
            background: linear-gradient(135deg, white, #f8fcff);
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            border: var(--season-border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), var(--season-shadow);
        }
        
        .product-modal-header {
            background: var(--cart-gradient);
            padding: 20px;
            color: white;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .product-modal-header h3 {
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .close-product-modal {
            background: rgba(255,255,255,0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        .product-modal-body {
            padding: 25px;
        }
        
        .product-modal-image {
            width: 100%;
            height: 250px;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            border: var(--season-border);
        }
        
        .product-modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-modal-info {
            margin-bottom: 20px;
        }
        
        .product-modal-price {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .product-modal-description {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .product-modal-features {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: var(--season-border);
        }
        
        .product-modal-features h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .product-modal-features ul {
            list-style: none;
            padding-left: 20px;
        }
        
        .product-modal-features li {
            margin-bottom: 8px;
            color: #555;
            position: relative;
            font-size: 15px;
        }
        
        .product-modal-features li:before {
            content: "✓";
            color: var(--primary-color);
            font-weight: bold;
            position: absolute;
            left: -20px;
        }
        
        .product-modal-actions {
            display: flex;
            gap: 15px;
        }
        
        .product-modal-actions button {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
        }
        
        .modal-add-to-cart {
            background: var(--cart-gradient);
            color: white;
        }
        
        .modal-close-btn {
            background: #f8f9fa;
            color: #555;
            border: 2px solid #ddd;
        }
        
        
        .contacts {
            padding: 25px 20px;
        }
        
        .contacts h3 {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .contact-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .contact-card {
            background: linear-gradient(135deg, rgba(77, 166, 255, 0.1), rgba(184, 225, 255, 0.2));
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: var(--season-border);
            transition: all 0.3s;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15), var(--season-shadow);
        }
        
        .contact-card i {
            color: var(--primary-color);
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .contact-card h5 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .contact-card p {
            color: #555;
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.5;
        }
        
        .phone-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #ff6b6b;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            margin-top: 15px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .phone-btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }
        
        
        .bottom {
            background: var(--header-gradient);
            color: white;
            padding: 25px 20px;
            margin-top: 40px;
            border-top: var(--season-border);
        }
        
        .bottom::before {
            content: var(--season-icon);
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 50px;
            opacity: 0.3;
        }
        
        .footer-text p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .footer-text .small {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        
        .footer-icons a {
            color: white;
            font-size: 22px;
            transition: all 0.3s;
        }
        
        .footer-icons a:hover {
            transform: translateY(-3px);
        }
        
        
        .cart-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .cart-modal.show {
            display: flex;
        }
        
        .cart-content {
            background: linear-gradient(135deg, white, #f8fcff);
            border-radius: 20px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3), var(--season-shadow);
            border: var(--season-border);
        }
        
        .cart-header {
            background: var(--cart-gradient);
            padding: 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid rgba(255,255,255,0.2);
            flex-shrink: 0;
        }
        
        .cart-header::before {
            content: var(--season-icon);
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 40px;
            opacity: 0.3;
        }
        
        .cart-header h2 {
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .close-cart {
            background: rgba(255,255,255,0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        .cart-scrollable {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        .cart-body {
            padding: 20px;
            flex: 1;
        }
        
        .empty-cart {
            padding: 40px 20px;
            text-align: center;
            color: #666;
        }
        
        .empty-cart i {
            font-size: 60px;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .empty-cart p {
            font-size: 18px;
        }
        
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            border: 2px solid var(--secondary-color);
            gap: 15px;
        }
        
        .cart-item-image {
            width: 70px;
            height: 70px;
            min-width: 70px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--secondary-color);
            background: #f8f9fa;
        }
        
        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .cart-item-info {
            flex: 1;
        }
        
        .cart-item-info h4 {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }
        
        .cart-item-price {
            font-size: 16px;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .quantity-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: var(--primary-color);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        
        .quantity {
            font-size: 16px;
            font-weight: bold;
            min-width: 25px;
            text-align: center;
        }
        
        .remove-item {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: #ff6b6b;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        
        .customer-form {
            padding: 20px;
            border-top: 3px solid var(--secondary-color);
        }
        
        .customer-form h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--secondary-color);
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
        }
        
        
        .cart-footer {
            background: #f8f9fa;
            border-top: 3px solid var(--secondary-color);
            padding: 20px;
            flex-shrink: 0;
        }
        
        .cart-total {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid var(--secondary-color);
        }
        
        .delivery-options {
            margin: 15px 0;
        }
        
        .delivery-options h4 {
            font-size: 16px;
            color: #555;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .delivery-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .delivery-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid var(--secondary-color);
            background: white;
            border-radius: 10px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .delivery-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .pickup-info, .delivery-address {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 12px;
            border: 2px solid var(--secondary-color);
        }
        
        .pickup-info h5, .delivery-address h5 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .pickup-address-select {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .address-option {
            padding: 12px;
            border: 2px solid var(--secondary-color);
            border-radius: 8px;
            cursor: pointer;
            background: white;
        }
        
        .address-option.selected {
            border-color: var(--primary-color);
            background: var(--secondary-color);
            font-weight: bold;
        }
        
        .address-option h5 {
            font-size: 15px;
            margin-bottom: 5px;
        }
        
        .address-option p {
            font-size: 14px;
            color: #666;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .grand-total {
            font-size: 20px;
            color: #333;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
        }
        
        .cart-actions {
            display: flex;
            gap: 12px;
        }
        
        .clear-cart-btn, .checkout-btn {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
        }
        
        .clear-cart-btn {
            background: #f8f9fa;
            color: #555;
            border: 2px solid #ddd;
        }
        
        .checkout-btn {
            background: var(--cart-gradient);
            color: white;
        }
        
        
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--cart-gradient);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            z-index: 5000;
            display: flex;
            align-items: center;
            gap: 8px;
            transform: translateX(150%);
            transition: transform 0.3s ease;
            max-width: 250px;
            font-size: 14px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        
        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }
            
            .items-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-cards {
                grid-template-columns: 1fr;
            }
            
            .nav {
                justify-content: space-between;
                gap: 5px;
                overflow-x: auto;
                padding-bottom: 10px;
                -webkit-overflow-scrolling: touch;
            }
            
            .nav::-webkit-scrollbar {
                display: none;
            }
            
            .nav-btn {
                padding: 8px 12px;
                font-size: 12px;
                min-width: 70px;
                flex: none;
            }
            
            .cart-content {
                max-width: 95%;
                max-height: 95vh;
                margin: 10px;
            }
            
            .cart-actions {
                flex-direction: column;
            }
            
            .logo-area {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .main-title {
                font-size: 18px;
            }
            
            .subtitle {
                font-size: 12px;
            }
            
            .product-photo {
                height: 150px;
            }
            
            .card h4 {
                font-size: 16px;
            }
            
            .card p {
                font-size: 14px;
            }
            
            .price-tag {
                font-size: 18px;
            }
            
            .welcome, .about, .products, .contacts {
                margin: 15px 10px;
                padding: 20px 15px;
            }
            
            .welcome p, .about p {
                font-size: 15px;
            }
            
            .delivery-buttons {
                flex-direction: column;
            }
            
            .product-modal-content {
                max-width: 95%;
                max-height: 85vh;
                margin: 10px;
            }
            
            .product-modal-actions {
                flex-direction: column;
            }
            
            .cart-item {
                flex-wrap: wrap;
                padding: 10px;
            }
            
            .cart-item-image {
                width: 60px;
                height: 60px;
                min-width: 60px;
            }
            
            .cart-item-info h4 {
                font-size: 14px;
            }
            
            .cart-scrollable {
                max-height: 70vh;
            }
            
            .customer-form {
                padding: 15px;
            }
            
            .cart-footer {
                padding: 15px;
            }
            
            .cart-total {
                padding: 15px;
            }
            
            .contact-card p {
                font-size: 15px;
            }
            
            .phone-btn {
                padding: 10px 20px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .nav-btn {
                padding: 6px 8px;
                font-size: 11px;
                min-width: 60px;
            }
            
            .logo-frame {
                width: 60px;
                height: 60px;
            }
            
            .main-title {
                font-size: 16px;
            }
            
            .contact-card {
                padding: 15px;
            }
            
            .photo-label {
                font-size: 10px;
                padding: 3px 8px;
            }
            
            .in-stock {
                font-size: 10px;
                padding: 3px 8px;
            }
            
            .cart-header h2 {
                font-size: 18px;
            }
            
            .product-modal-header h3 {
                font-size: 18px;
            }
            
            .contact-card p {
                font-size: 14px;
            }
            
            .phone-btn {
                padding: 8px 16px;
                font-size: 14px;
            }
            
            .form-input {
                font-size: 14px;
                padding: 10px;
            }
            
            .notification {
                max-width: 200px;
                font-size: 13px;
            }
        }
    </style>
    
    <style>
        #seasonParticles, .header-decoration, .season-indicator { display: none !important; }
        .logo-frame, .main-title, .photo-label, .garland-light { animation: none !important; }
        .card, .nav-btn, .add-to-cart-btn, .phone-btn, .footer-icons a, .view-details, .delivery-btn, .address-option {
            transition: background-color .18s ease, border-color .18s ease, color .18s ease, box-shadow .18s ease !important;
        }
        .card:hover, .nav-btn:hover, .add-to-cart-btn:hover, .phone-btn:hover, .footer-icons a:hover { transform: none !important; }
        .cart-modal { padding: 16px; }
        .cart-content {
            width: min(680px, 96vw);
            max-width: 680px;
            max-height: 88vh;
            overflow: hidden;
            border-radius: 28px !important;
        }
        .cart-scrollable {
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-gutter: stable;
            padding-right: 2px;
        }
        .cart-body, .customer-form, .cart-footer {
            width: 100%;
            overflow: visible;
            padding-left: 22px;
            padding-right: 22px;
        }
        .cart-body { padding-top: 22px; padding-bottom: 10px; }
        .customer-form {
            border-top: 2px solid rgba(77,166,255,.18);
            padding-top: 22px;
            padding-bottom: 16px;
        }
        .customer-form h4 {
            font-size: 22px;
            line-height: 1.2;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .customer-form .alert-login-state { display: none !important; }
        .form-group label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .form-input {
            min-height: 52px;
            border-radius: 14px;
            box-shadow: none;
        }
        textarea.form-input {
            min-height: 104px;
            resize: vertical;
        }
        .cart-total {
            border-radius: 18px;
            padding: 22px;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }
        .delivery-options { margin-top: 18px; }
        .delivery-options h4 {
            font-size: 22px;
            line-height: 1.2;
            margin-bottom: 14px;
            font-weight: 700;
        }
        .delivery-buttons {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 12px;
            margin-bottom: 16px;
            align-items: stretch;
        }
        .delivery-btn {
            min-height: 64px;
            min-width: 0;
            width: 100%;
            padding: 12px 14px;
            white-space: normal;
            text-align: center;
            line-height: 1.2;
            font-size: 16px;
            font-weight: 700;
            border-radius: 14px;
        }
        .pickup-info, .delivery-address {
            border-radius: 16px;
            padding: 18px;
            margin-top: 8px;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }
        .pickup-info h5, .delivery-address h5 {
            font-size: 18px;
            margin-bottom: 12px;
        }
        .pickup-address-select { gap: 10px; }
        .address-option {
            border-radius: 14px;
            padding: 14px 16px;
        }
        .address-option h5 { font-size: 18px; margin-bottom: 6px; }
        .address-option p { font-size: 15px; }
        .total-row { font-size: 18px; }
        .grand-total { font-size: 30px; }
        .cart-actions { gap: 12px; }
        .clear-cart-btn, .checkout-btn {
            min-height: 56px;
            border-radius: 14px;
            font-size: 17px;
        }
        .empty-cart { padding: 24px 12px; }
        .bottom { position: relative; }
        .footer-links { margin-top: 14px; text-align: center; font-size: 14px; }
        .footer-links a { color: #fff; opacity: .95; text-decoration: none; margin: 0 10px; border-bottom: 1px solid rgba(255,255,255,.35); }
        .footer-links a:hover { opacity: 1; }
        .close-cart { box-shadow: none; }
        small.phone-format-hint { display: none !important; }

        @media (max-width: 768px) {
            .cart-modal { padding: 10px; }
            .cart-content {
                width: calc(100vw - 20px);
                max-width: calc(100vw - 20px);
                max-height: 90vh;
                border-radius: 24px !important;
            }
            .cart-body, .customer-form, .cart-footer {
                padding-left: 16px;
                padding-right: 16px;
            }
            .customer-form h4, .delivery-options h4 {
                font-size: 20px;
            }
            .delivery-buttons {
                grid-template-columns: repeat(2, minmax(0,1fr));
                gap: 10px;
            }
            .delivery-btn {
                min-height: 58px;
                font-size: 14px;
                padding: 10px;
            }
            .pickup-info h5, .delivery-address h5, .address-option h5 { font-size: 16px; }
            .address-option p, .total-row { font-size: 14px; }
            .grand-total { font-size: 22px; }
            .clear-cart-btn, .checkout-btn { min-height: 50px; font-size: 15px; }
        }
    </style>

</head>
<body>
    
    <div id="seasonParticles"></div>

    
    <div class="top">
        <div class="header-decoration" id="headerDecoration">
            
        </div>
        <div class="logo-area">
            <div class="logo-frame">
                <img src="лого.png" alt="Логотип Olivka_Dreams" class="logo-img">
            </div>
            <div class="title-box">
                <h1 class="main-title">Olivka_Dreams <span class="season-indicator" id="seasonIndicator">❄️</span></h1>
                <p class="subtitle">Магазин муслиновых изделий для малышей и мам</p>
            </div>
        </div>
        
        
        <div class="nav">
            <a href="#" class="nav-btn"><i class="fas fa-home"></i> Главная</a>
            <a href="#items" class="nav-btn"><i class="fas fa-shopping-basket"></i> Товары</a>
            <a href="#contact" class="nav-btn"><i class="fas fa-address-book"></i> Контакты</a>
            <?php if ($customerLoggedIn): ?>
                <a href="account/profile.php" class="nav-btn"><i class="fas fa-user"></i> Кабинет</a>
            <?php else: ?>
                <a href="account/login.php" class="nav-btn"><i class="fas fa-user"></i> Войти</a>
            <?php endif; ?>
            <a href="#" class="nav-btn cart-btn" id="cartBtn">
                <i class="fas fa-shopping-cart"></i> Корзина 
                <span class="cart-count" id="cartCount">0</span>
            </a>
        </div>
    </div>

    
    <div class="welcome">
        <h2><i class="fas fa-child"></i> Добро пожаловать в Olivka_Dreams!</h2>
        <p>Качественные муслиновые изделия для малышей и удобные аксессуары для мам. Подберите идеальные товары для вашего малыша в любую погоду!</p>
    </div>

    
    <div class="about">
        <h3><i class="fas fa-info-circle"></i> О нашем магазине</h3>
        <p>Мы создаем уютные и безопасные изделия из натуральных материалов. Все товары прошли контроль качества и созданы с любовью. Каждый сезон мы предлагаем специальные коллекции!</p>
    </div>

    
    <div class="products" id="items">
        <h3><i class="fas fa-gift"></i> Наши товары</h3>
        
        <div class="items-grid">
<?php foreach ($products as $product): ?>
<?php
    $isAvailable = trim(mb_strtolower((string)$product['status_text'])) === 'в наличии';
?>
            <div class="card">
                <div class="product-photo">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="product-img">
                    <div class="photo-label"><?= htmlspecialchars($product['badge']) ?></div>
                </div>
                <h4><?= htmlspecialchars($product['title']) ?></h4>
                <p><?= htmlspecialchars($product['short_description']) ?></p>
                <div class="product-details">
                    <div class="price-tag"><?= number_format((int)$product['price'], 0, '', ' ') ?> ₽</div>
                    <div class="sizes"><?= htmlspecialchars($product['sizes_text']) ?></div>
                </div>
                <div class="product-status">
                    <span class="<?= $isAvailable ? 'in-stock' : 'in-stockk' ?>">
                        <?= htmlspecialchars($product['status_text']) ?>
                    </span>
                </div>
                <button class="view-details" onclick="showProductDetails(<?= (int)$product['id'] ?>)">
                    <i class="fas fa-eye"></i> Подробнее о товаре
                </button>

                <?php if ($isAvailable): ?>
                <button class="add-to-cart-btn" onclick="addToCart(<?= (int)$product['id'] ?>)">
                    <i class="fas fa-cart-plus"></i> В корзину
                </button>
                <?php else: ?>
                <button class="add-to-cart-btn disabled-btn" disabled>
                    <i class="fas fa-ban"></i> Нет в наличии
                </button>
                <?php endif; ?>
            </div>
<?php endforeach; ?>
        </div>
    </div>

    
    <div class="contacts" id="contact">
        <h3><i class="fas fa-phone-alt"></i> Как нас найти</h3>
        
        <div class="contact-cards">
            <div class="contact-card">
                <i class="fas fa-map-marked-alt"></i>
                <h5>Доставка</h5>
                <p>г. Ижевск 25км</p>
            </div>
            
            <div class="contact-card">
                <i class="fas fa-mobile-alt"></i>
                <h5>Телефон</h5>
                <p>+7 982 818 9420</p>
                <p>+7 917 919 3949</p>
                <a href="tel:+79828189420" class="phone-btn">
                    <i class="fas fa-phone"></i> Позвонить
                </a>
            </div>
            
            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h5>Почта</h5>
                <p>olivkadreams@yandex.ru</p>
                <a href="mailto:olivkadreams@yandex.ru" class="phone-btn">
                    <i class="fas fa-envelope"></i> Написать
                </a>
            </div>
            
            <div class="contact-card">
                <i class="fas fa-clock"></i>
                <h5>Время работы</h5>
                <p>Пн-Вск: 9:00-20:00</p>
            </div>
        </div>
    </div>

    
    <div class="bottom">
        <div class="footer-text">
            <p>© 2025 Магазин детских товаров</p>
            <p class="small">Безопасные материалы ∙ Конфиденциальность ∙ Забота о каждом малыше</p>
        </div>
        
        <div class="footer-icons">
            <a href="https://t.me/haltobina" target="_blank"><i class="fab fa-telegram"></i></a>
            <a href="https://wa.me/79828189420" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
        <div class="footer-links">
            <?php if ($customerLoggedIn): ?>
                <a href="account/profile.php">Личный кабинет</a>
            <?php else: ?>
                <a href="account/login.php">Вход для клиента</a>
            <?php endif; ?>
            <a href="account/register.php">Регистрация клиента</a>
            <a href="admin/index.php">Админ-панель</a>
        </div>
    </div>

    
    <div class="product-modal" id="productModal">
        <div class="product-modal-content">
            <div class="product-modal-header">
                <h3><i class="fas fa-info-circle"></i> Подробности товара</h3>
                <button class="close-product-modal" id="closeProductModal">&times;</button>
            </div>
            <div class="product-modal-body" id="productModalBody">
                
            </div>
        </div>
    </div>

    
    <div class="cart-modal" id="cartModal">
        <div class="cart-content">
            <div class="cart-header">
                <h2><i class="fas fa-shopping-cart"></i> Корзина</h2>
                <button class="close-cart" id="closeCart">&times;</button>
            </div>
            
            <div class="cart-scrollable">
                <div class="cart-body" id="cartBody">
                    <div class="empty-cart" id="emptyCart">
                        <i class="fas fa-shopping-basket"></i>
                        <p>Ваша корзина пуста</p>
                    </div>
                    
                    <div class="cart-items" id="cartItems">
                        
                    </div>
                </div>
                
                
                <div class="customer-form">
                    <h4><i class="fas fa-user"></i> Ваши данные</h4>
                    
                    <div class="form-group">
                        <label for="customerName"><i class="fas fa-user-circle"></i> Имя:</label>
                        <input type="text" id="customerName" class="form-input" placeholder="Введите ваше имя" value="<?= htmlspecialchars($customerName) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="customerPhone"><i class="fas fa-phone"></i> Телефон:</label>
                        <input type="tel" id="customerPhone" class="form-input" 
                               placeholder="+7 (___) ___-__-__" 
                               value="<?= htmlspecialchars($customerPhone) ?>"
                               pattern="^\+7\s?[\(]?\d{3}[\)]?\s?\d{3}[\s-]?\d{2}[\s-]?\d{2}$"
                               title="Введите номер телефона в формате: +7 (999) 999-99-99"
                               required>
                        
                    </div>
                    <div class="form-group">
                        <label for="customerComment"><i class="fas fa-comment"></i> Комментарий к заказу:</label>
                        <textarea id="customerComment" class="form-input" placeholder="Дополнительные пожелания" rows="3"></textarea>
                    </div>
                </div>
                
                
                <div class="cart-footer">
                    <div class="cart-total">
                        <div class="total-row">
                            <span>Товары:</span>
                            <span id="subtotal">0 ₽</span>
                        </div>
                        
                        <div class="delivery-options">
                            <h4><i class="fas fa-truck"></i> Способ получения:</h4>
                            <div class="delivery-buttons">
                                <button class="delivery-btn active" data-type="pickup">
                                    <i class="fas fa-store"></i> Самовывоз
                                </button>
                                <button class="delivery-btn" data-type="courier">
                                    <i class="fas fa-truck"></i> Курьер
                                </button>
                                <button class="delivery-btn" data-type="avito_delivery">
                                    <i class="fas fa-box"></i> Авито доставка
                                </button>
                                <button class="delivery-btn" data-type="yandex_courier">
                                    <i class="fas fa-motorcycle"></i> Яндекс курьер
                                </button>
                            </div>
                            
                            <div class="pickup-info" id="pickupInfo">
                                <h5><i class="fas fa-map-marker-alt"></i> Выберите адрес самовывоза:</h5>
                                <div class="pickup-address-select">
                                    <div class="address-option selected" data-address="Пушкинская 227">
                                        <h5><i class="fas fa-map-pin"></i> Пушкинская 227</h5>
                                        <p>Ежедневно 10:00-20:00</p>
                                    </div>
                                    <div class="address-option" data-address="Красина 45">
                                        <h5><i class="fas fa-map-pin"></i> Красина 45</h5>
                                        <p>Ежедневно 10:00-20:00</p>
                                    </div>
                                    <div class="address-option" data-address="Автозаводская 19а">
                                        <h5><i class="fas fa-map-pin"></i> Автозаводская 19а</h5>
                                        <p>Ежедневно 10:00-20:00</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="delivery-address" id="deliveryAddress" style="display: none;">
                                <h5><i class="fas fa-home"></i> Адрес / детали доставки:</h5>
                                <textarea id="addressInput" class="form-input" placeholder="Введите адрес, ссылку на объявление Авито или комментарий для Яндекс курьера"></textarea>
                                
                            </div>
                        </div>
                        
                        
                        <div id="deliveryCostRow" style="display: none;">
                            <div class="total-row">
                                <span>Доставка:</span>
                                <span id="deliveryCost">0 ₽</span>
                            </div>
                        </div>
                        
                        <div class="total-row grand-total">
                            <span><strong>Итого:</strong></span>
                            <span id="grandTotal">0 ₽</span>
                        </div>
                    </div>
                    
                    <div class="cart-actions">
                        <button class="clear-cart-btn" id="clearCart">
                            <i class="fas fa-trash"></i> Очистить корзину
                        </button>
                        <button class="checkout-btn" id="checkoutBtn">
                            <i class="fab fa-telegram"></i> Оформить заказ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productsDatabase = <?= json_encode($productsJs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let deliveryType = 'pickup';
        let selectedAddress = 'Пушкинская 227';
        let currentProductId = null;
        let currentSeason = 'winter';
        const deliveryTypeLabels = {
            pickup: 'Самовывоз',
            courier: 'Курьер',
            avito_delivery: 'Авито доставка',
            yandex_courier: 'Яндекс курьер'
        };
        function getDeliveryMeta(type, subtotal) {
            switch(type) {
                case 'courier':
                    return { cost: subtotal >= 3000 ? 0 : 300, note: subtotal >= 3000 ? 'Бесплатно' : formatPrice(300) + ' ₽' };
                case 'avito_delivery':
                    return { cost: 0, note: 'По тарифу Авито' };
                case 'yandex_courier':
                    return { cost: 0, note: 'По тарифу Яндекс Go' };
                default:
                    return { cost: 0, note: '0 ₽' };
            }
        }
        function updateSeasonByDate() {
            const now = new Date();
            const month = now.getMonth() + 1;
            
            let newSeason;
            if (month >= 12 || month <= 2) newSeason = 'winter';
            else if (month >= 3 && month <= 5) newSeason = 'spring';
            else if (month >= 6 && month <= 8) newSeason = 'summer';
            else newSeason = 'autumn';
            
            if (newSeason !== currentSeason) {
                changeSeason(newSeason);
            }
        }
        function createWinterGarland() {
            const headerDecoration = document.getElementById('headerDecoration');
            headerDecoration.innerHTML = '';
            for (let line = 0; line < 2; line++) {
                const garlandLine = document.createElement('div');
                garlandLine.className = 'garland-line';
                garlandLine.style.top = (line * 15 + 5) + 'px';
                for (let i = 0; i < 15; i++) {
                    const light = document.createElement('div');
                    light.className = 'garland-light';
                    const colors = ['#ff0000', '#00ff00', '#ffff00', '#00ffff', '#ff00ff', '#ff8800'];
                    light.style.backgroundColor = colors[i % colors.length];
                    light.style.color = colors[i % colors.length];
                    const position = (i / 14) * 100;
                    light.style.left = position + '%';
                    light.style.animationDelay = (i * 0.2) + 's';
                    light.style.animationDuration = (1 + Math.random() * 2) + 's';
                    
                    garlandLine.appendChild(light);
                }
                
                headerDecoration.appendChild(garlandLine);
            }
        }
        
        function changeSeason(season) {
            currentSeason = season;
            const root = document.documentElement;
            const seasonIndicator = document.getElementById('seasonIndicator');
            const seasonParticles = document.getElementById('seasonParticles');
            const headerDecoration = document.getElementById('headerDecoration');
            
            seasonParticles.innerHTML = '';
            headerDecoration.innerHTML = '';
            
            switch(season) {
                case 'winter':
                    root.style.setProperty('--primary-color', '#4da6ff');
                    root.style.setProperty('--secondary-color', '#b8e1ff');
                    root.style.setProperty('--season-color', '#8ad8ff');
                    root.style.setProperty('--background-color', '#f8fcff');
                    root.style.setProperty('--card-bg', 'linear-gradient(135deg, white, #f0f9ff)');
                    root.style.setProperty('--header-gradient', 'linear-gradient(135deg, #4da6ff, #8ad8ff)');
                    root.style.setProperty('--season-icon', "'❄️'");
                    root.style.setProperty('--season-particles', "'❄️'");
                    root.style.setProperty('--season-border', '2px solid #8ad8ff');
                    root.style.setProperty('--season-shadow', '0 0 20px rgba(138, 216, 255, 0.3)');
                    seasonIndicator.textContent = '❄️';
                    createWinterGarland();
                    for (let i = 0; i < 30; i++) {
                        const snowflake = document.createElement('div');
                        snowflake.className = 'season-particle';
                        snowflake.textContent = '❄️';
                        snowflake.style.left = `${Math.random() * 100}%`;
                        snowflake.style.animationDelay = `${Math.random() * 5}s`;
                        snowflake.style.fontSize = `${Math.random() * 15 + 15}px`;
                        snowflake.style.opacity = Math.random() * 0.7 + 0.3;
                        snowflake.style.animationName = 'snowfall';
                        snowflake.style.animationDuration = `${Math.random() * 5 + 5}s`;
                        seasonParticles.appendChild(snowflake);
                    }
                    break;
                    
                case 'spring':
                    root.style.setProperty('--primary-color', '#ff66aa');
                    root.style.setProperty('--secondary-color', '#ffb8d9');
                    root.style.setProperty('--season-color', '#ff88cc');
                    root.style.setProperty('--background-color', '#fff8fc');
                    root.style.setProperty('--card-bg', 'linear-gradient(135deg, white, #fff0f8)');
                    root.style.setProperty('--header-gradient', 'linear-gradient(135deg, #ff66aa, #ffb8d9)');
                    root.style.setProperty('--season-icon', "'🌸'");
                    root.style.setProperty('--season-particles', "'🌸'");
                    root.style.setProperty('--season-border', '2px solid #ff88cc');
                    root.style.setProperty('--season-shadow', '0 0 20px rgba(255, 136, 204, 0.3)');
                    seasonIndicator.textContent = '🌸';
                    for (let i = 0; i < 8; i++) {
                        const flower = document.createElement('div');
                        flower.className = 'season-particle';
                        flower.textContent = '🌸';
                        flower.style.left = `${Math.random() * 100}%`;
                        flower.style.animationDelay = `${Math.random() * 3}s`;
                        flower.style.fontSize = `${Math.random() * 20 + 20}px`;
                        flower.style.animationName = 'blossom-fall';
                        flower.style.animationDuration = `${Math.random() * 8 + 8}s`;
                        seasonParticles.appendChild(flower);
                    }
                    break;
                    
                case 'summer':
                    root.style.setProperty('--primary-color', '#00cc66');
                    root.style.setProperty('--secondary-color', '#66ffaa');
                    root.style.setProperty('--season-color', '#33ff99');
                    root.style.setProperty('--background-color', '#f8fff8');
                    root.style.setProperty('--card-bg', 'linear-gradient(135deg, white, #f0fff0)');
                    root.style.setProperty('--header-gradient', 'linear-gradient(135deg, #00cc66, #66ffaa)');
                    root.style.setProperty('--season-icon', "'☀️'");
                    root.style.setProperty('--season-particles', "'🏖️'");
                    root.style.setProperty('--season-border', '2px solid #33ff99');
                    root.style.setProperty('--season-shadow', '0 0 20px rgba(51, 255, 153, 0.3)');
                    seasonIndicator.textContent = '☀️';
                    for (let i = 0; i < 20; i++) {
                        const sand = document.createElement('div');
                        sand.className = 'season-particle';
                        sand.textContent = '🏖️';
                        sand.style.left = `${Math.random() * 100}%`;
                        sand.style.animationDelay = `${Math.random() * 2}s`;
                        sand.style.fontSize = `${Math.random() * 10 + 15}px`;
                        sand.style.animationName = 'sand-fall';
                        sand.style.animationDuration = `${Math.random() * 6 + 4}s`;
                        seasonParticles.appendChild(sand);
                    }
                    break;
                    
                case 'autumn':
                    root.style.setProperty('--primary-color', '#ff8800');
                    root.style.setProperty('--secondary-color', '#ffcc66');
                    root.style.setProperty('--season-color', '#ffaa33');
                    root.style.setProperty('--background-color', '#fff8f0');
                    root.style.setProperty('--card-bg', 'linear-gradient(135deg, white, #fff8f0)');
                    root.style.setProperty('--header-gradient', 'linear-gradient(135deg, #ff8800, #ffcc66)');
                    root.style.setProperty('--season-icon', "'🍂'");
                    root.style.setProperty('--season-particles', "'🍁'");
                    root.style.setProperty('--season-border', '2px solid #ffaa33');
                    root.style.setProperty('--season-shadow', '0 0 20px rgba(255, 170, 51, 0.3)');
                    seasonIndicator.textContent = '🍂';
                    for (let i = 0; i < 25; i++) {
                        const leaf = document.createElement('div');
                        leaf.className = 'season-particle';
                        leaf.textContent = Math.random() > 0.5 ? '🍁' : '🍂';
                        leaf.style.left = `${Math.random() * 100}%`;
                        leaf.style.animationDelay = `${Math.random() * 4}s`;
                        leaf.style.fontSize = `${Math.random() * 15 + 15}px`;
                        leaf.style.animationName = 'leaves-fall';
                        leaf.style.animationDuration = `${Math.random() * 10 + 5}s`;
                        seasonParticles.appendChild(leaf);
                    }
                    break;
            }
            
            localStorage.setItem('season', season);
        }
        function validatePhoneInput(event) {
            const input = event.target;
            let value = input.value;
            value = value.replace(/[^\d+\-()\s]/g, '');
            if (!value.startsWith('+7') && !value.startsWith('7') && !value.startsWith('8')) {
                if (value.length > 0) {
                    value = '+7' + value.replace(/\D/g, '');
                }
            }
            if (value.startsWith('+7')) {
                let numbers = value.replace(/\D/g, '').substring(1); // Убираем +7
                
                if (numbers.length > 0) {
                    value = '+7';
                    
                    if (numbers.length <= 3) {
                        value += ' (' + numbers;
                    } else if (numbers.length <= 6) {
                        value += ' (' + numbers.substring(0, 3) + ') ' + numbers.substring(3);
                    } else if (numbers.length <= 8) {
                        value += ' (' + numbers.substring(0, 3) + ') ' + numbers.substring(3, 6) + '-' + numbers.substring(6);
                    } else {
                        value += ' (' + numbers.substring(0, 3) + ') ' + numbers.substring(3, 6) + '-' + numbers.substring(6, 8) + '-' + numbers.substring(8, 10);
                    }
                }
            }
            
            input.value = value;
        }
        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartCount').textContent = count;
        }
        
        function addToCart(productId) {
            const product = productsDatabase[productId];
            if (!product) return;
            
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id: productId,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            updateCartDisplay();
            showNotification(`${product.name} добавлен в корзину`);
        }
        
        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            updateCartDisplay();
        }
        
        function updateQuantity(productId, delta) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += delta;
                if (item.quantity < 1) {
                    removeFromCart(productId);
                    return;
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                updateCartDisplay();
            }
        }
        
        function clearCart() {
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            updateCartDisplay();
            showNotification('Корзина очищена');
        }
        
        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            const emptyCart = document.getElementById('emptyCart');
            const subtotalElement = document.getElementById('subtotal');
            const deliveryCostElement = document.getElementById('deliveryCost');
            const grandTotalElement = document.getElementById('grandTotal');
            const deliveryCostRow = document.getElementById('deliveryCostRow');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '';
                emptyCart.style.display = 'block';
                subtotalElement.textContent = '0 ₽';
                grandTotalElement.textContent = '0 ₽';
                deliveryCostRow.style.display = 'none';
                return;
            }
            
            emptyCart.style.display = 'none';
            
            let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let deliveryCost = 0;
            let total = subtotal;
            
            if (deliveryType === 'pickup') {
                deliveryCostRow.style.display = 'none';
            } else {
                const deliveryMeta = getDeliveryMeta(deliveryType, subtotal);
                deliveryCost = deliveryMeta.cost;
                total = subtotal + deliveryCost;
                deliveryCostRow.style.display = 'block';
                deliveryCostElement.textContent = deliveryMeta.note;
            }
            
            subtotalElement.textContent = formatPrice(subtotal) + ' ₽';
            grandTotalElement.textContent = formatPrice(total) + ' ₽';
            
            cartItems.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <div class="cart-item-price">${formatPrice(item.price)} ₽</div>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="quantity-btn minus" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn plus" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                    <div class="cart-item-total">
                        ${formatPrice(item.price * item.quantity)} ₽
                    </div>
                    <button class="remove-item" onclick="removeFromCart(${item.id})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `).join('');
        }
        
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.classList.add('show'), 10);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }
        function showProductDetails(productId) {
            currentProductId = productId;
            const product = productsDatabase[productId];
            if (!product) return;
            
            const modalBody = document.getElementById('productModalBody');
            
            let featuresHtml = '';
            if (product.features && product.features.length > 0) {
                featuresHtml = `
                    <div class="product-modal-features">
                        <h4><i class="fas fa-star"></i> Особенности:</h4>
                        <ul>
                            ${product.features.map(feature => `<li>${feature}</li>`).join('')}
                        </ul>
                    </div>
                `;
            }
            
            let detailsHtml = '';
            if (product.sizes) detailsHtml += `<p><strong>Размеры:</strong> ${Array.isArray(product.sizes) ? product.sizes.join(', ') : product.sizes}</p>`;
            if (product.colors) detailsHtml += `<p><strong>Цвета:</strong> ${Array.isArray(product.colors) ? product.colors.join(', ') : product.colors}</p>`;
            if (product.material) detailsHtml += `<p><strong>Материал:</strong> ${product.material}</p>`;
            if (product.size) detailsHtml += `<p><strong>Размер:</strong> ${product.size}</p>`;
            if (product.bulkPricing) {
                detailsHtml += `<p><strong>Оптовые цены:</strong><br>${product.bulkPricing.map(price => `${price}`).join('<br>')}</p>`;
            }
            
            modalBody.innerHTML = `
                <div class="product-modal-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="product-modal-info">
                    <h4>${product.name}</h4>
                    <div class="product-modal-price">${formatPrice(product.price)} ₽</div>
                    <div class="product-modal-description">
                        ${product.description}
                    </div>
                    ${detailsHtml ? `<div class="product-modal-details">${detailsHtml}</div>` : ''}
                    ${featuresHtml}
                </div>
                <div class="product-modal-actions">
                    <button class="modal-add-to-cart" onclick="addToCartFromModal()">
                        <i class="fas fa-cart-plus"></i> В корзину
                    </button>
                    <button class="modal-close-btn" onclick="closeProductModal()">
                        <i class="fas fa-times"></i> Закрыть
                    </button>
                </div>
            `;
            
            document.getElementById('productModal').classList.add('show');
        }
        
        function addToCartFromModal() {
            if (currentProductId) {
                addToCart(currentProductId);
                closeProductModal();
            }
        }
        
        function closeProductModal() {
            document.getElementById('productModal').classList.remove('show');
            currentProductId = null;
        }
        async function sendOrderToBackend(orderData) {
            const BACKEND_URL = 'api/create_order.php';

            try {
                const response = await fetch(BACKEND_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(orderData)
                });
                
                if (!response.ok) {
                    throw new Error(`Ошибка сервера: ${response.status}`);
                }
                
                return await response.json();
            } catch (error) {
                console.error('Ошибка при отправке заказа:', error);
                throw error;
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            const savedSeason = localStorage.getItem('season');
            if (savedSeason) {
                changeSeason(savedSeason);
            } else {
                updateSeasonByDate();
            }
            const phoneInput = document.getElementById('customerPhone');
            if (phoneInput) {
                phoneInput.addEventListener('input', validatePhoneInput);
                phoneInput.addEventListener('paste', function(e) {
                    e.preventDefault();
                    let pastedText = (e.clipboardData || window.clipboardData).getData('text');
                    pastedText = pastedText.replace(/\D/g, '');
                    if (pastedText.startsWith('7') || pastedText.startsWith('8')) {
                        pastedText = '+7' + pastedText.substring(1);
                    } else if (!pastedText.startsWith('+7')) {
                        pastedText = '+7' + pastedText;
                    }
                    phoneInput.value = pastedText;
                    validatePhoneInput({target: phoneInput});
                });
            }
            document.getElementById('cartBtn').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('cartModal').classList.add('show');
                updateCartDisplay();
            });
            document.getElementById('closeCart').addEventListener('click', function() {
                document.getElementById('cartModal').classList.remove('show');
            });
            document.getElementById('closeProductModal').addEventListener('click', closeProductModal);
            document.getElementById('productModal').addEventListener('click', function(e) {
                if (e.target === this) closeProductModal();
            });
            document.getElementById('clearCart').addEventListener('click', clearCart);
            document.querySelectorAll('.delivery-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.delivery-btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    deliveryType = this.getAttribute('data-type');
                    
                    if (deliveryType === 'pickup') {
                        document.getElementById('pickupInfo').style.display = 'block';
                        document.getElementById('deliveryAddress').style.display = 'none';
                    } else {
                        document.getElementById('pickupInfo').style.display = 'none';
                        document.getElementById('deliveryAddress').style.display = 'block';
                    }
                    
                    updateCartDisplay();
                });
            });
            document.querySelectorAll('.address-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.address-option').forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedAddress = this.getAttribute('data-address');
                });
            });
            document.getElementById('checkoutBtn').addEventListener('click', async function() {
                if (cart.length === 0) {
                    showNotification('Добавьте товары в корзину');
                    return;
                }
                
                const name = document.getElementById('customerName').value.trim();
                const phone = document.getElementById('customerPhone').value.trim();
                const comment = document.getElementById('customerComment').value.trim();
                
                if (!name || !phone) {
                    showNotification('Заполните имя и телефон');
                    return;
                }
                const phonePattern = /^\+7\s?[\(]?\d{3}[\)]?\s?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/;
                if (!phonePattern.test(phone)) {
                    showNotification('Введите корректный номер телефона в формате: +7 (999) 999-99-99');
                    return;
                }
                
                let address = '';
                let deliveryLabel = deliveryTypeLabels[deliveryType] || deliveryType;
                if (deliveryType !== 'pickup') {
                    const addressInput = document.getElementById('addressInput').value.trim();
                    if (!addressInput) {
                        showNotification('Введите адрес или детали доставки');
                        return;
                    }
                    address = addressInput;
                } else {
                    address = selectedAddress;
                }
                
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const deliveryMeta = getDeliveryMeta(deliveryType, subtotal);
                const deliveryCost = deliveryMeta.cost;
                const total = subtotal + deliveryCost;
                
                const orderData = {
                    customerInfo: {
                        name: name,
                        phone: phone,
                        deliveryType: deliveryType,
                        deliveryLabel: deliveryLabel,
                        address: address,
                        comment: comment || "Без комментария"
                    },
                    items: cart.map(item => ({
                        name: item.name,
                        price: item.price,
                        quantity: item.quantity,
                        total: item.price * item.quantity
                    })),
                    subtotal: subtotal,
                    deliveryCost: deliveryCost,
                    grandTotal: total
                };
                
                showNotification('Отправляем заказ...');
                
                try {
                    await sendOrderToBackend(orderData);
                    showNotification('Заказ успешно отправлен!');
                    cart = [];
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    updateCartDisplay();
                    document.getElementById('cartModal').classList.remove('show');
                    document.getElementById('customerName').value = '';
                    document.getElementById('customerPhone').value = '';
                    document.getElementById('customerComment').value = '';
                    
                } catch (error) {
                    showNotification('Ошибка при отправке заказа');
                    console.error(error);
                }
            });
        });
    </script>
</body>
</html>

