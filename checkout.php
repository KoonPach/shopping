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
<body class="bg-light">

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-body p-4">

            <h2 class="text-center mb-4 text-primary">Checkout</h2>

            <?php if ($rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Product Name</th>
                                <th>Price (THB)</th>
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
                                    <td class="text-end"><?php echo number_format($product['price'], 2); ?></td>
                                    <td class="text-center"><?php echo $quantity; ?></td>
                                    <td class="text-end text-success fw-semibold"><?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-end text-danger mt-3">Total: <span class="fw-bold"><?php echo number_format($total, 2); ?> THB</span></h4>

                <hr class="my-4">

                <h5 class="mb-3">Shipping Information</h5>
                <form action="process_checkout.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Place Order</button>
                        <a href="index.php" class="btn btn-outline-secondary ms-2">← Continue Shopping</a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    Your cart is empty. <a href="index.php" class="btn btn-link">Go back to shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
