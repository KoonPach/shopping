<?php
session_start(); 
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
    <link href="<?php echo $base_url; ?>/product-list.css" rel="stylesheet">

</head>
<body class="bg-light">
    <?php include 'include/menu.php'; ?>
    
    <div class="container mt-4">
        <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-info me-2"></i><?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        
        
        <div class="row g-4">
            <?php if ($rows > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($query)): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="product-card card h-100">
                        <div class="product-image-container">
                            <?php if (!empty($product['profile_image'])): ?>
                            <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['profile_image']; ?>" class="product-image" alt="<?php echo $product['product_name']; ?>">
                            <?php else: ?>
                            <img src="<?php echo $base_url; ?>/upload_image/no-image.png" class="product-image" alt="No Image Available">
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title" title="<?php echo $product['product_name']; ?>"><?php echo $product['product_name']; ?></h5>
                            <p class="price fw-bold mb-1"><?php echo number_format($product['price'], 2); ?> Baht</p>
                            <p class="card-text text-muted detail-text mb-3"><?php echo nl2br($product['detail']); ?></p>
                            <a href="<?php echo $base_url; ?>/cart-add.php?id=<?php echo $product['id']; ?>" class="btn btn-primary cart-btn mt-auto">
                                <i class="fa-solid fa-cart-plus me-2"></i>Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card shadow text-center py-5">
                        <div class="card-body">
                            <i class="fa-solid fa-store fa-3x text-muted mb-3"></i>
                            <h4>No products available</h4>
                            <p class="text-muted">Check back later for new products</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</body>
</html>