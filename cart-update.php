<?php
session_start();
include 'config.php';

if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $product_id => $productQty) {
        $productQty = (int)$productQty;
        if ($productQty > 0) {
            $_SESSION['cart'][$product_id] = $productQty;
        } else {
            unset($_SESSION['cart'][$product_id]); // ลบสินค้าที่มีจำนวนเป็น 0
        }
    }
}

$_SESSION['message'] = "Cart updated successfully";
header('Location: cart.php');