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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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


        <h4>Cart</h4>
        <div class="row">
            <div class = "col-12">
                <form action = "<?php echo $base_url; ?>/cart-update.php" method = "POST">
            <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Product Name</th>
                    <th style="width: 200px;">Price</th>
                    <th style="width: 100px;">Quantity</th>
                    <th style="width: 200px;">Total</th>
                    <th style="width: 120px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php if($rows > 0): ?>
                    <?php while($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td>
                            <?php if(!empty($row['profile_image'])): ?>
                                <img src="<?php echo $base_url; ?>/upload_image/<?php echo $row['profile_image']; ?>" alt="Product Image" class="img-fluid" style="width: 100px; height: 100px;">
                            <?php else: ?>
                                <img src="<?php echo $base_url; ?>/upload_image/no-image.png" width="100" alt="Product Image" class="img-fluid">
                            <?php endif; ?>   
                        </td>
                        <td>
                            <?php echo $row['product_name']; ?>
                        <div>
                            <small class="text-muted"><?php echo nl2br($row['detail']); ?></small>
                        </div>
                        </td>
                        <td> <?php echo number_format($row['price'], 2); ?> </td>
                         
                        <td>
                            <input type="number" name="quantity[<?php echo $row['id']; ?>]" value="<?php echo $_SESSION['cart'][$row['id']]; ?>" class="form-control">
                        </td>
                         <td> 
                            <?php echo number_format($row['price'] * $_SESSION['cart'][$row['id']], 2); ?>

                         </td>        


                        <td>
                            <a onclick= "return confirm('ลบอาหาร')" "button" href="<?php echo $base_url; ?>/cart-delete.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                    <tr>
                        <td colspan="6" class="text-end">
                            <button type="submit"  class="btn btn-lg btn-success ">Update Cart</button>    
                            <a href="<?php echo $base_url; ?>/checkout.php" class="btn btn-primary btn-lg"><i class="fa-solid fa-credit-card"></i> Checkout</a>

                        </td>
                    </tr>


                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีสินค้าในตระกร้า</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </form>

            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>