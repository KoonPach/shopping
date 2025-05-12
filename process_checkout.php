<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $grand_total = 0;

    // คำนวณยอดรวมจาก session cart
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $query = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
        $product = mysqli_fetch_assoc($query);
        if ($product) { 
            $grand_total += $product['price'] * $quantity;
        }
    }

    
    $sql = "INSERT INTO orders (fullname, email, tel, grand_total) 
            VALUES ('$fullname', '$email', '$phone', '$grand_total')";

    if (mysqli_query($conn, $sql)) {
       
        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error placing order: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>