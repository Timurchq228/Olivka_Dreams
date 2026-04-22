<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin_auth(): void
{
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function is_customer_logged_in(): bool
{
    return !empty($_SESSION['customer_id']);
}

function require_customer_auth(): void
{
    if (!is_customer_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
