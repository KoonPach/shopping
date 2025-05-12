<?php
session_start();
include 'config.php';

$product_id = [];
foreach (($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
    $product_id[] = $cartId;
}

$ids = 0;
if (count($product_id) > 0) {
    $ids = implode(',', $product_id);
}

// Fetch products in the cart
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$rows = mysqli_num_rows($query);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="container my-5">
    <h1 class="text-center mb-4">Checkout</h1>

    <?php if ($rows > 0): ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($query)): ?>
                    <?php
                    $quantity = $_SESSION['cart'][$product['id']];
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="text-end">Total: <?php echo number_format($total, 2); ?></h3>

        <form action="process_checkout.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="fullname" class="form-label">Fullname:</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    <?php else: ?>
        <p class="text-center">Your cart is empty. <a href="index.php" class="btn btn-link">Go back to shopping</a>.</p>
    <?php endif; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>