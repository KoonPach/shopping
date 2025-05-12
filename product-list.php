<?php
session_start(); // Start the session
include 'config.php';

//product all
$query = mysqli_query($conn, "SELECT * FROM products") or die(mysqli_error($conn));
$rows = mysqli_num_rows($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.css" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
    <?php include 'include/menu.php'; ?>

    <div class="container" style=" margin-top: 30px;">
        <?php if(!empty($_SESSION['message'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
            <?php endif; ?>


        <h4>Product List</h4>
        <div class="row d-flex justify-content-center">
            <?php if ($rows > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($query)): ?>
                    <div class="col-3 mb-3">
                        <div class="card" style="width: 18rem;">
                                <?php if (!empty($product['profile_image'])): ?>
                                <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image']; ?>" class="card-img-top img-fluid" alt="Product Image" style="width: 200px; height: 200px;">
                            <?php else: ?>
                                <img src="<?php echo $base_url; ?>/upload_image/no-image.png" class="card-img-top img-fluid" alt="Product Image" style="width: 200px; height: 200px;">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p class="card-text text-seccess fw-bold mb-0"><?php echo number_format($product['price'], 2); ?> Baht</p>
                                <p class="card-text text-muted"><?php echo nl2br($product['detail']); ?></p>
                            
                                <a href="<?php echo $base_url; ?>/cart-add.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100"><i class="fa-solid fa-cart-plus"></i> Add Cart</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <h5>No products available</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>