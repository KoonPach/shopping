<?php

session_start();
include 'config.php';

if(!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='".$_GET['id']."'");
    $result = mysqli_fetch_assoc($query_product);
    @unlink('upload_image/' . $result['profile_image']);

    $query = mysqli_query($conn, "DELETE FROM products WHERE id='".$_GET['id']."'") or die(mysqli_error($conn));
    mysqli_close($conn);

    if ($query) {
        $_SESSION['message'] = "Product deleted successfully!";
        header('Location: ' . $base_url . '/index.php');
    } else {
        $_SESSION['message'] = "Failed to delete product!";
        header('Location: ' . $base_url . '/index.php');
    }

}