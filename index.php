<?php
session_start(); // Start the session
include 'config.php';

//product all
$query = mysqli_query($conn, "SELECT * FROM products") or die(mysqli_error($conn));
$rows = mysqli_num_rows($query);



$result = [
    'id' => '',
    'product_name' => '',
    'price' => '',
    'detail' => '',
    'profile_image' => ''
];


//product select edit
if(!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id = '".$_GET['id']."'") or die(mysqli_error($conn));
    $row_product = mysqli_num_rows($query_product);

    if($row_product == 0) {
        header("Location: ".$base_url."/index.php");
    } 
    $result = mysqli_fetch_assoc($query_product);

    


} 



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>
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


        <h4>Home - Manage Product</h4>
        <div class= "row g-5">
        <div class="col-md-8 col-sm-12">
            <form action = "<?php echo $base_url; ?>/product-form.php" method = "POST" enctype = "multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="product_name" value="<?php echo $result['product_name']; ?>">
                </div>

                <div class="col-sm-6">
                    <label class="form-label">Product Price</label>
                    <input type="number" class="form-control" name="price" value="<?php echo $result['price']; ?>">
                </div>

                <div class="col-sm-6">
                     <?php if(!empty($result['profile_image'])): ?>
                        <div>
                        <img src="<?php echo $base_url; ?>/upload_image/<?php echo $result['profile_image']; ?>" alt="Product Image" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>
                       
                        <?php endif; ?>
                    <label class="formFile">Image</label>
                    <input type="file" class="form-control" name="profile_image" accept=".jpg, .jpeg, .png">
                </div>

                <div class="col-sm-12">
                    <label class="form-label">Detail</label>
                    <textarea name = "detail" class="form-control" rows="3"><?php echo $result['detail']; ?></textarea>
                </div>
            </div>
            <?php if(empty($result['id'])): ?>
            <button type="submit" class="btn btn-primary">Create</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary">Update</button>    
            <?php endif; ?>
                <a role = "button" class="btn btn-secondary" href = "<?php echo $base_url; ?> ">Cancel</a>
                
                <hr class ="my-4">

            </form>
        </div>
    </div>

        <div class = "row">
            <div class = "col-12">
            <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Product Name</th>
                    <th style="width: 200px;">Price</th>
                    <th style="width: 200px;">Action</th>
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
                            <a role="button" href="<?php echo $base_url; ?>/index.php?id=<?php echo $row['id']; ?>" 
                            class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

                            <a onclick= "return confirm('ลบอาหาร')" "button" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>