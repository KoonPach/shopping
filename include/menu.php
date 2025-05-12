<header class="sticky-top bg-white border-bottom shadow-sm">
    <nav class="container d-flex flex-wrap justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="<?php echo $base_url; ?>/index.php" class="nav-link text-dark fw-semibold px-4">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $base_url; ?>/product-list.php" class="nav-link text-dark fw-semibold px-4">
                    Product List
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $base_url; ?>/cart.php" class="nav-link position-relative text-dark fw-semibold px-4">
                    Cart
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</header>
