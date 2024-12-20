<?php
// Include the necessary files
require_once '../../database.php';
require_once '../../Controller/CartController.php';
require_once 'AddToCart.php';

// Instantiate the Database class and get the PDO connection
$database = new Database();
$pdo = $database->connect(); 

// Check if the connection is successful
if ($pdo === null) {
    die("Database connection failed!");
}

// Fetch product from the database
$query = "SELECT * FROM product";  
$stmt = $pdo->query($query);       
$product = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cart Modal
$cartController = new CartController();
$cartItems = $cartController->getCart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Farmnet - Your online farm shop">
    <meta name="author" content="Farmnet">
    <title>Farmnet</title>
    <link rel="icon" href="Assets/images/fevicon.png" type="image/gif">
    
    <!-- Bootstrap CSS (minimized and updated) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="Assets/css/bootstrap.min.css" />
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="Assets/css/style.css" />
    <!-- Responsive-->
    <link rel="stylesheet" href="Assets/css/responsive.css" />
    <!-- fevicon -->
    <link rel="icon" href="Assets/images/fevicon.png" type="image/gif" />
    <!-- font css -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800;1,400&family=Sen:wght@400;700;800&display=swap"
      rel="stylesheet"
    />
    
    <!-- Tweaks for older IEs-->
    <link
      rel="stylesheet"
      href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
    
    <!-- Font and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;800&family=Sen:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Assets/css/jquery.mCustomScrollbar.min.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.html">
                    <img src="Assets/images/Farmnet(LOGO).png" alt="Farmnet Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">


                  <li class="nav-item">
                     <a class="nav-link" href="../front_office/html/index.html">home</a>
                     </li>
                  
                     <li class="nav-item">
                     <a class="nav-link" href="../frontOffice2/index.php">event</a>
                     </li>
                  
                  
                     <li class="nav-item">
                        <a class="nav-link" href="../front_office/html/questionpage.php">question</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="index.php">cart</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../Frontoffice/ArticlesList.php">article</a>
                     </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" href="../reclamations_view.php">reclamation </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../frontOffice2/profile.php">profile </a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  </form>
               </div>
            </nav>
        </div>
    </header>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($cartItems)): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>$<?php echo number_format($item['total_price'], 2); ?></td>
                                        <td><a href="removeFromCart.php?cart_id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Vegetables Section -->
    <section class="vagetables_section layout_padding">
        <div class="container">
            <h1 class="vagetables_taital">Our Vegetables</h1>
            <p class="vagetables_text">Fresh products picked specially for you !</p>

            <div class="courses_section_2">
                <div class="row">
                    <?php foreach ($product as $product): ?>
                        <div class="col-md-4">
                            <div class="hover01 column">
                                <figure>
                                    <img src="Assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" data-toggle="modal" data-target="#productModal<?php echo $product['id']; ?>" />
                                </figure>
                            </div>
                            <h3 class="harshal_text"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <h3 class="rate_text">$<?php echo number_format($product['price'], 2); ?></h3>
                            <a href="Shop.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                        </div>

                        <!-- Product Modal -->
                        <div class="modal fade" id="productModal<?php echo $product['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productModalLabel"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="Assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid" />
                                        <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
                                        <p><strong>Price:</strong> TND <?php echo number_format($product['price'], 2); ?></p>
                                        <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['stock']); ?> available</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="Shop.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Useful links</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Address</h3>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> Farmnet, Tunisia</li>
                        <li><i class="fa fa-phone"></i> (+71) 1234567890</li>
                        <li><i class="fa fa-envelope"></i> demo@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3 class="footer_text">Find Us</h3>
                    <div class="social_icon">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Javascript files-->
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/popper.min.js"></script>
    <script src="Assets/js/bootstrap.bundle.min.js"></script>
    <script src="Assets/js/jquery-3.0.0.min.js"></script>
    <script src="Assets/js/plugin.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
