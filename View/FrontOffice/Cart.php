<?php
require_once '../../Controller/CartController.php';
$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $CartController = new CartController();
    $result = $cartController->checkout();
    echo $result['message'];
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/cart.css">
    <!-- Favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html">
                    <img src="images/Farmnet(LOGO).png" alt="Farmnet Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="vagetables.html">Vegetables</a></li>
                        <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="openCartModal()">My Cart</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- Cart Modal 
<div id="cart-modal" class="modal">
    <div class="modal-content">
    <span onclick="closeCartModal()">Close</span>
        <h2>Your Cart</h2>
        <div id="cart-items"></div>
        <p id="cart-total"></p>
        <a href="Cart.php" class="btn btn-primary">Go to My Cart</a>
    </div>
</div>-->

<div class="container">
    <h1>Your Cart</h1>
    <div class="row">
        <?php if (!empty($list)): ?>
            <?php foreach ($list as $produit): ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($produit['image']); ?>" 
                             alt="<?= htmlspecialchars($produit['nomproduit']); ?>" 
                             style="width: 100%;">
                        <h3><?= htmlspecialchars($produit['nomproduit']); ?></h3>
                        <p>Price: $<?= htmlspecialchars($produit['prix']); ?></p>
                        <p>Quantite: <?= htmlspecialchars($CartModel['quantite']); ?></p>
                        <form method="POST" action="../../Controller/CartController.php">
                            
                            <input type="hidden" name="nomproduit" value="<?= htmlspecialchars($produit['nomproduit']); ?>">
                            <input type="hidden" name="prix" value="<?= htmlspecialchars($produit['prix']); ?>">
                            <input type="hidden" name="image" value="<?= htmlspecialchars($produit['image']); ?>">
                            <input type="hidden" name="quantite" value="<?= htmlspecialchars($produit['quantite']); ?>">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/Cart.js"></script>
</body>
</html>
