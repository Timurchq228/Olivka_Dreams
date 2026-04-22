<?php
session_start();
unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_email'], $_SESSION['customer_phone']);
header('Location: ../index.php');
exit;
