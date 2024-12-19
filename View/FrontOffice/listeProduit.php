<?php
require_once '../../controller/ProduitController.php';
$produitC = new ProduitController();
$list = $produitC->listProduit();
//session_start(); // Start the session at the beginning of the script

// Example to add a product to the cart (assuming product details are passed in the request)
if (isset($_POST['add_to_cart'])) {
    // Get product details from POST request (example values)
    $id = $_POST['id'];
    $nomproduit = $_POST['nomproduit'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $image = $_POST['image'];

    // Add product to the cart (stored in session)
    $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $nomproduit,
        'price' => $prix,
        'image' => $image,
        'quantite' => $quantite,
        'prix_total' => $prix * $quantite // Calculating subtotal for each product
    ];
}
try {
   // Establish the connection using the config class
   $pdo = config::getConnexion();

   // Check if 'add_to_cart' button is clicked and a product ID is provided
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
       $product_id = (int)$_POST['product_id']; // Cast to ensure it's an integer

       // Retrieve product details from 'produit' table
       $query = "SELECT nomproduit, prix, quantite FROM produit WHERE id = :id";
       $stmt = $pdo->prepare($query);
       $stmt->execute(['id' => $product_id]);

       if ($stmt->rowCount() > 0) {
           $product = $stmt->fetch();
           $nomproduit = $product['nomproduit'];
           $prix = $product['prix'];
           $quantite = 1; // Default to adding 1 item to the cart

           // Insert product details into 'commande' table
           $insertQuery = "INSERT INTO commande (nomproduit, prix, quantite) VALUES (:nomproduit, :prix, :quantite)";
           $insertStmt = $pdo->prepare($insertQuery);
           $insertStmt->execute([
               'nomproduit' => $nomproduit,
               'prix' => $prix,
               'quantite' => $quantite,
           ]);

           echo "Product added to cart successfully!";
       } else {
           echo "Product not found!";
       }
   }

   // Fetch all products from 'produit' table to display
   $query = "SELECT * FROM produit";
   $products = $pdo->query($query)->fetchAll();
} catch (Exception $e) {
   die('Error: ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- site metas -->
      <title>Shop</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!--product style-->
      <link rel="stylesheet" type="text/css" href="css/product.css">
      <!-- font-awesome -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Swiper CSS via CDN -->
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" >
      <!--<link rel="stylesheet" href="css/swiper-bundle.min.css" />-->


   </head>
   <body>
      <!-- Header Section -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                     <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                     <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                     <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  </form>
                  <!-- Cart Icon -->
                  <button class="btn btn-outline-primary ml-2" id="cart-icon"><i class="fa fa-shopping-cart"></i>Cart</button>
               </div>
            </nav>
         </div>
      </div>

      <!-- Cart Modal -->
      <div id="cart-modal" style="display:none; position:fixed; top:0; right:0; bottom:0; left:0; background-color: rgba(0,0,0,0.7); z-index: 999;">
         <div style="width: 50%; margin: 0 auto; background-color: #fff; padding: 20px;">
            <h2>Your Cart</h2>
            <div id="cart-items"></div>
            <div id="cart-total"></div>
            <button id="close-cart-modal" class="btn btn-danger">Close</button>
            <a id="open-cart" class="btn btn-light" href="Cart.php">Go to my cart</a>
            <div class="cart-actions">
            <button id="checkout-button" class="btn btn-success">Checkout</button>
</div>
<script>
    document.getElementById('checkout-button').addEventListener('click', () => {
        fetch('checkout.php', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                cart: <?= json_encode($cartItems); ?> // Pass the cart data to the backend
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Optionally, redirect the user to another page (e.g., order confirmation)
                window.location.href = "Cart.php";
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>


         </div>
      </div>

      <!-- Layout Border Start -->
      <div class="container-fluid">
         <div class="layout_border">
            <div class="vagetables_section layout_padding margin_bottom90">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <h1 class="vagetables_taital">Our Products</h1>
                        <p class="vagetables_text">Discover our range of fresh products available</p>
                     </div>
                  </div>
                  <div class="courses_section_2">
                     <div class="row">
                        <?php
                        // Loop to display each product
                        while ($produit = $list->fetch()) {
                        ?>
                           <div class="col-md-4">
                              <div class="hover01 column">
                                 <figure><img src="projetWeb/uploads<?= htmlspecialchars($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nomproduit']); ?>"></figure>

                              </div>
                              <h3 class="harshal_text"><?= htmlspecialchars($produit['nomproduit']); ?></h3>
                              <h3 class="rate_text">TND<?= htmlspecialchars($produit['prix']); ?></h3>
                              <p class="quantity_text">Available quantity: <?= htmlspecialchars($produit['quantite']); ?></p>
                              <button class="btn btn-primary add-to-cart-btn" data-id="<?= $produit['id']; ?>" data-name="<?= htmlspecialchars($produit['nomproduit']); ?>" data-price="<?= $produit['prix']; ?>" data-image="<?= $produit['image']; ?>">Add to Cart</button>
                           </div>
                        <?php
                        }
                        
// Include the config file
require_once '../../config.php';

try {
    // Establish the connection using the config class
    $pdo = config::getConnexion();

    // Check if 'add_to_cart' button is clicked and a product ID is provided
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
        $product_id = (int)$_POST['product_id']; // Cast to ensure it's an integer

        // Retrieve product details from 'produit' table
        $query = "SELECT nomproduit, prix, quantite FROM produit WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $product_id]);

        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch();
            $nomproduit = $product['nomproduit'];
            $prix = $product['prix'];
            $quantite = 1; // Default to adding 1 item to the cart

            // Insert product details into 'commande' table
            $insertQuery = "INSERT INTO commande (nomproduit, prix, quantite) VALUES (:nomproduit, :prix, :quantite)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute([
                'nomproduit' => $nomproduit,
                'prix' => $prix,
                'quantite' => $quantite,
            ]);

            echo "Product added to cart successfully!";
        } else {
            echo "Product not found!";
        }
    }

    // Fetch all products from 'produit' table to display
    $query = "SELECT * FROM produit";
    $products = $pdo->query($query)->fetchAll();
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

                        ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Footer Section Start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-4 col-sm-6">
                  <h3 class="footer_text">Useful links</h3>
                  <div class="footer_menu">
                     <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <h3 class="footer_text">Address</h3>
                  <div class="location_text">
                     <ul>
                        <li><a href="#"><i class="fa fa-map-marker"></i> Address here</a></li>
                        <li><a href="#"><i class="fa fa-phone"></i> (+71) 1234567890</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> demo@gmail.com</a></li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6">
                  <h3 class="footer_text">Find Us</h3>
                  <div class="social_icon">
                     <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Footer Section End -->

      <!-- Copyright Section Start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2023 All Rights Reserved.</p>
         </div>
      </div>
      <!-- Copyright Section End -->

      <!-- Javascript files -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/Cart.js"></script>
   </body>
</html>
 