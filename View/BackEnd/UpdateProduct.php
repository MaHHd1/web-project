<?php

// Include the ProductController
require_once '../../Controller/ProductController.php';

// Initialize variables
$error = "";
$product = null;
$productController = new ProductController();

if (
    isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock'])
) {
    if (
        !empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['stock'])
    ) {
        $imagePath = null;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($imageExtension), $allowedExtensions)) {
                // Ensure the upload directory exists
                $uploadDir = __DIR__ . '/../../Assets/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadPath = $uploadDir . uniqid('product_', true) . '.' . $imageExtension;

                if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                    $imagePath = str_replace(__DIR__ . '/../../', '', $uploadPath); // Relative path for storage
                } else {
                    $error = "Failed to upload the image.";
                }
            } else {
                $error = "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        }

        // Validate inputs
        if (empty($error)) {
            // Create product array
            $product = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'image' => $imagePath
            ];

            // Call the update function
            if ($productController->updateProduct($_POST['id'], $product)) {
                header('Location: productList.php');
                exit();
            } else {
                $error = "Failed to update the product.";
            }
        }
    } else {
        $error = "Missing information.";
    }
}

// Display error if any
if (!empty($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>




<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="Assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="Assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      Now UI Dashboard by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="Assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="Assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <link rel="stylesheet" href="Assets/css/buttonStyle.css"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="Assets/demo/demo.css" rel="stylesheet" />
  </head>

  <body class="user-profile">
    <div class="wrapper ">
      <div class="sidebar" data-color="orange">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
        <div class="logo">
          <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            CT
          </a>
          <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            Creative Tim
          </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
          <ul class="nav">
            <!--<li>
              <a href="./dashboard.html">
                <i class="now-ui-icons design_app"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li>
              <a href="./icons.html">
                <i class="now-ui-icons education_atom"></i>
                <p>Icons</p>
              </a>
            </li>
            <li>
              <a href="./map.html">
                <i class="now-ui-icons location_map-big"></i>
                <p>Maps</p>
              </a>
            </li>
            <li>
              <a href="./notifications.html">
                <i class="now-ui-icons ui-1_bell-53"></i>
                <p>Notifications</p>
              </a>
            </li>-->
            <li class="active ">
              <a href="AddProduct.php">
                <i class="now-ui-icons users_single-02"></i>
                <p>Add Product</p>
              </a>
            </li>
            <li>
              <a href="ProductList.php">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p>Product List</p>
              </a>
            </li>
            <!--<li>
              <a href="./typography.html">
                <i class="now-ui-icons text_caps-small"></i>
                <p>Typography</p>
              </a>
            </li>
            <li class="active-pro">
              <a href="./upgrade.html">
                <i class="now-ui-icons arrows-1_cloud-download-93"></i>
                <p>Upgrade to PRO</p>
              </a>
            </li>-->
          </ul>
        </div>
      </div>
      <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
          <div class="container-fluid">
            <div class="navbar-wrapper">
              <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                  <span class="navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </button>
              </div>
              <a class="navbar-brand" href="#pablo">User Profile</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-bar navbar-kebab"></span>
              <span class="navbar-toggler-bar navbar-kebab"></span>
              <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <form>
                <div class="input-group no-border">
                  <input type="text" value="" class="form-control" placeholder="Search...">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                    </div>
                  </div>
                </div>
              </form>
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="#pablo">
                    <i class="now-ui-icons media-2_sound-wave"></i>
                    <p>
                      <span class="d-lg-none d-md-block">Stats</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="now-ui-icons location_world"></i>
                    <p>
                      <span class="d-lg-none d-md-block">Some Actions</span>
                    </p>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#pablo">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>
                      <span class="d-lg-none d-md-block">Account</span>
                    </p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">
        </div>
        <div class="content">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">

                <h2>Update Product</h2>

  <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
          <ul>
              <?php foreach ($errors as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
          </ul>
      </div>
  <?php endif; ?>

  <form method="POST" action="updateProduct.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
    

    <div class="form-group">
        <label for="name">Product Name</label><br>
        <input type="text" class="form-control" name="name" id="name" >
    </div>

    <div class="form-group">
        <label for="description">Description</label><br>
        <input type="text" class="form-control" name="description" id="description" >
    </div>

    <div class="form-group">
        <label for="price">Price</label><br>
        <input type="number" step="0.01" class="form-control" name="price" id="price" >
    </div>

    <div class="form-group">
        <label for="stock">Stock</label><br>
        <input type="number" class="form-control" name="stock" id="stock" >
    </div>

    <div class="form-group">
        <label for="image" class="image-upload-label">Product Image</label><br>
        <input type="file" class="form-control image-upload-input" name="image" id="image">
    </div>

    <input type="submit" name="updateProduct" value="Update Product" class="btn btn-primary">
</form>



              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class=" container-fluid ">
            <nav>
              <ul>
                <li>
                  <a href="https://www.creative-tim.com">
                    Creative Tim
                  </a>
                </li>
                <li>
                  <a href="http://presentation.creative-tim.com">
                    About Us
                  </a>
                </li>
                <li>
                  <a href="http://blog.creative-tim.com">
                    Blog
                  </a>
                </li>
              </ul>
            </nav>
            <div class="copyright" id="copyright">
              &copy; <script>
                document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
              </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="Assets/js/core/jquery.min.js"></script>
    <script src="Assets/js/core/popper.min.js"></script>
    <script src="Assets/js/core/bootstrap.min.js"></script>
    <script src="Assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="Assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="Assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="Assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="Assets/demo/demo.js"></script>
  </body>

  </html>