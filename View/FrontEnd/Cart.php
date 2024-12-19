<?php
require_once '../../Controller/CartController.php';

$cartController = new CartController();
$cartItems = $cartController->getCart();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1" />
    <!-- site metas -->
    <title>Farmnet</title>
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="images\Farmnet(LOGO).ico"
    />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="Assets/css/bootstrap.min.css" />
    <!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
    <!-- Tweaks for older IEs-->
    <link
      rel="stylesheet"
      href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"
    />
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="index.html"
            ><img src="Assets/images/Farmnet(LOGO).png"
          /></a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="Index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="Shop.php">Shop</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="vagetables.html">Vagetables</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="blog.html">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li>
              <li class="nav-item">
                            <button type="button" class="btn btn-success nav-link" data-toggle="modal" data-target="#cartModal">View Cart</button>
                        </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <div class="search_icon">
                <i class="fa fa-search" aria-hidden="true"></i>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
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
    <!-- header section end -->
    <!-- layout_border start -->
    <div class="container-fluid">
      <div class="layout_border">>
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
                  <td>
                    <a href="removeFromCart.php?cart_id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                  </td>
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
    <div class="container mt-5">
        <h1 class="mb-4">Your Cart</h1>

        <?php if (!empty($cartItems)): ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Price (TND)</th>
                        <th>Quantity</th>
                        <th>Total Price (TND)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['total_price'], 2); ?></td>
                            <td>
                                <a href="removeFromCart.php?cart_id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <!--Footer Section-->
    <div class="footer_section layout_padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <h3 class="footer_text">Useful links</h3>
            <div class="footer_menu">
              <ul>
                <li class="active">
                  <a href="index.html"
                    ><span class="angle_icon active"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    Home</a
                  >
                </li>
                <li>
                  <a href="about.html"
                    ><span class="angle_icon"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    About</a
                  >
                </li>
                <li>
                  <a href="services.html"
                    ><span class="angle_icon"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    Services</a
                  >
                </li>
                <li>
                  <a href="domain.html"
                    ><span class="angle_icon"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    Domain</a
                  >
                </li>
                <li>
                  <a href="testimonial"
                    ><span class="angle_icon"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    Testimonial</a
                  >
                </li>
                <li>
                  <a href="contact.html"
                    ><span class="angle_icon"
                      ><i class="fa fa-arrow-right" aria-hidden="true"></i
                    ></span>
                    Contact Us</a
                  >
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <h3 class="footer_text">Address</h3>
            <div class="location_text">
              <ul>
                <li>
                  <a href="#">
                    <span class="padding_left_10"
                      ><i class="fa fa-map-marker" aria-hidden="true"></i></span
                    >It is a long established fact that a<br />
                    reader will be distracted</a
                  >
                </li>
                <li>
                  <a href="#">
                    <span class="padding_left_10"
                      ><i class="fa fa-phone" aria-hidden="true"></i></span
                    >(+71) 1234567890<br />(+71) 1234567890
                  </a>
                </li>
                <li>
                  <a href="#">
                    <span class="padding_left_10"
                      ><i class="fa fa-envelope" aria-hidden="true"></i></span
                    >demo@gmail.com
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="footer_main">
              <h3 class="footer_text">Find Us</h3>
              <p class="dummy_text">more-or-less normal distribution</p>
              <div class="social_icon">
                <ul>
                  <li>
                    <a href="#"
                      ><i class="fa fa-facebook" aria-hidden="true"></i
                    ></a>
                  </li>
                  <li>
                    <a href="#"
                      ><i class="fa fa-twitter" aria-hidden="true"></i
                    ></a>
                  </li>
                  <li>
                    <a href="#"
                      ><i class="fa fa-instagram" aria-hidden="true"></i
                    ></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- footer section end -->
    <!-- copyright section start -->
    <div class="copyright_section">
      <div class="container">
        <p class="copyright_text">
          2023 All Rights Reserved. Design by
          <a href="https://html.design">Free html Templates</a>
        </p>
      </div>
    </div>
    <!-- copyright section end -->
    <!-- Javascript files-->
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/popper.min.js"></script>
    <script src="Assets/js/bootstrap.bundle.min.js"></script>
    <script src="Assets/js/jquery-3.0.0.min.js"></script>
    <script src="Assets/js/plugin.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
