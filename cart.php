<?php
session_start(); 
include 'config.php';

$product_id = [];
foreach(($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
    $product_id[] = $cartId;
}

$ids = 0;
if(count($product_id) > 0) {
    $ids = implode(',', $product_id);
} 


//product all
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$rows = mysqli_num_rows($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-product {
      margin-bottom: 1rem;
    }
    .product-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
    }
    .btn-action {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <?php include 'include/menu.php'; ?>

  <div class="container my-4">
    <?php if(!empty($_SESSION['message'])): ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h3 class="mb-4">Your Shopping Cart</h3>

    <form action="<?php echo $base_url; ?>/cart-update.php" method="POST">
      <?php if($rows > 0): ?>
        <?php while($row = mysqli_fetch_array($query)): ?>
          <div class="card card-product shadow-sm">
            <div class="card-body row align-items-center">
              <div class="col-md-2 text-center">
                <?php if(!empty($row['profile_image'])): ?>
                  <img src="<?php echo $base_url; ?>/upload_image/<?php echo $row['profile_image']; ?>" alt="Product Image" class="img-thumbnail product-image">
                <?php else: ?>
                  <img src="<?php echo $base_url; ?>/upload_image/no-image.png" class="img-thumbnail product-image" alt="No image">
                <?php endif; ?>
              </div>

              <div class="col-md-4">
                <h5><?php echo $row['product_name']; ?></h5>
                <p class="text-muted mb-1 small"><?php echo nl2br($row['detail']); ?></p>
              </div>

              <div class="col-md-2 text-end">
                <p class="mb-1"><strong>฿<?php echo number_format($row['price'], 2); ?></strong></p>
              </div>

              <div class="col-md-1">
                <input type="number" name="quantity[<?php echo $row['id']; ?>]" value="<?php echo $_SESSION['cart'][$row['id']]; ?>" class="form-control" min="1">
              </div>

              <div class="col-md-2 text-end">
                <strong>฿<?php echo number_format($row['price'] * $_SESSION['cart'][$row['id']], 2); ?></strong>
              </div>

              <div class="col-md-1 text-end">
                <a onclick="return confirm('ลบอาหาร?')" href="<?php echo $base_url; ?>/cart-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>

        <div class="d-flex justify-content-end gap-3 mt-4">
          <button type="submit" class="btn btn-success btn-lg">
            Update Cart
          </button>
          <a href="<?php echo $base_url; ?>/checkout.php" class="btn btn-primary btn-lg">
            Checkout
          </a>
        </div>
      <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
          ไม่มีสินค้าในตระกร้า
        </div>
      <?php endif; ?>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
