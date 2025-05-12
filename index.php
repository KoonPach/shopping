<?php
session_start(); // Start the session
include 'config.php';

// Fetch all products
$query = mysqli_query($conn, "SELECT * FROM products") or die(mysqli_error($conn));
$rows = mysqli_num_rows($query);

// Initialize product data
$result = [
    'id' => '',
    'product_name' => '',
    'price' => '',
    'detail' => '',
    'profile_image' => ''
];

// Fetch product for editing
if (!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id = '" . $_GET['id'] . "'") or die(mysqli_error($conn));
    $row_product = mysqli_num_rows($query_product);

    if ($row_product == 0) {
        header("Location: " . $base_url . "/index.php");
        exit;
    }

    $result = mysqli_fetch_assoc($query_product);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/brands.min.css" rel="stylesheet">
  <link href="<?php echo $base_url; ?>/assets/fontawesome/css/solid.css" rel="stylesheet">
  <style>
    .card {
      border-radius: 1rem;
    }
    .btn {
      border-radius: 0.5rem;
    }
  </style>
</head>
<body class="bg-light">

  <?php include 'include/menu.php'; ?>

  <div class="container my-5">
    <!-- Flash Message -->
    <?php if (!empty($_SESSION['message'])): ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="row g-4">
      <!-- Product Form -->
      <div class="col-md-6">
        <div class="card shadow-sm p-4">
          <h5 class="mb-3 text-primary">
            
            <?php echo empty($result['id']) ? 'Add New Product' : 'Edit Product'; ?>
          </h5>
          <form action="<?php echo $base_url; ?>/product-form.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">

            <div class="mb-3">
              <label class="form-label">Product Name</label>
              <input type="text" class="form-control" name="product_name" value="<?php echo $result['product_name']; ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Product Price</label>
              <input type="number" class="form-control" name="price" value="<?php echo $result['price']; ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image</label>
              <input type="file" class="form-control" name="profile_image" accept=".jpg, .jpeg, .png">
              <?php if (!empty($result['profile_image'])): ?>
                <img src="<?php echo $base_url; ?>/upload_image/<?php echo $result['profile_image']; ?>" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Detail</label>
              <textarea name="detail" class="form-control" rows="3"><?php echo $result['detail']; ?></textarea>
            </div>

            <div class="d-flex gap-2 mt-3">
              <button type="submit" class="btn btn-primary">
                <?php echo empty($result['id']) ? 'Create' : 'Update'; ?>
              </button>
              <a href="<?php echo $base_url; ?>" class="btn btn-secondary">Cancel
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- Product List -->
      <div class="col-md-6">
        <div class="card shadow-sm p-4">
          <h5 class="text-primary">Product List</h5>
          <div class="table-responsive mt-3">
            <table class="table table-hover align-middle table-bordered rounded shadow-sm">
              <thead class="table-primary text-center">
                <tr>
                  <th style="width: 100px;">Image</th>
                  <th>Product Name</th>
                  <th style="width: 130px;">Price (THB)</th>
                  <th style="width: 160px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($rows > 0): ?>
                  <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                      <td class="text-center">
                        <img src="<?php echo $base_url; ?>/upload_image/<?php echo $row['profile_image'] ?: 'no-image.png'; ?>" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                      </td>
                      <td>
                        <strong><?php echo $row['product_name']; ?></strong><br>
                        <small class="text-muted"><?php echo nl2br($row['detail']); ?></small>
                      </td>
                      <td class="text-end text-success fw-semibold">
                        <?php echo number_format($row['price'], 2); ?>
                      </td>
                      <td class="text-center">
                        <a href="<?php echo $base_url; ?>/index.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning mb-1">
                          <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a onclick="return confirm('ลบอาหาร?')" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger">
                          <i class="fa-solid fa-trash"></i> Delete
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                      <i class="fa-solid fa-box-open fa-lg mb-2 d-block"></i>
                      No products found.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
