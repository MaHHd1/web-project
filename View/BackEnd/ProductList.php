<?php
// Include necessary files for database connection and models
require_once('../../database.php');  // Database connection configuration
require_once('../../Models/ProductModel.php'); // Assuming you have this model to interact with the DB
require_once('../../Controller/ProductController.php'); // Controller to handle the business logic


// Create an instance of ProductController
$productController = new ProductController();

// Handle delete action
if (isset($_GET['delete_product'])) {
  $id = $_GET['delete_product'];

  // Call delete method from the controller
  $deleteSuccess = $productController->deleteProduct($id);

  // Check if deletion was successful
  if ($deleteSuccess) {
      // Redirect to ProductList.php to refresh the product list after deletion
      header('Location: ProductList.php');
      exit();
  } else {
      echo '<p style="color: red;">Failed to delete the product.</p>';
  }
}
// Fetch all products
$products = $productController->index(); // Call the index() method to fetch products
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="Assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="Assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Product List</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link href="Assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="Assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <link href="Assets/demo/demo.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-color="orange">
      <div class="logo">
        <a href="#" class="simple-text logo-normal">Farmnet</a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="AddProduct.php">
              <i class="now-ui-icons users_single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li class="active">
            <a href="ProductList.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Product List</p>
            </a>
          </li>
          <li>
            <a href="CropHealth.php">
            <i class="fas fa-leaf"></i>
              <p>Crop Health / Weather</p>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="main-panel" id="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Product List</a>
        </div>
      </nav>

      <div class="panel-header panel-header-sm"></div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Product List</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="text-primary">
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th class="text-right">Stock</th>
                      <th class="text-right">Image</th>
                      <th class="text-right">Action</th>
                    </thead>
                    <tbody>
                      <?php foreach ($products as $product): ?>
                      <tr>
                        <!-- Product Name -->
                        <td><?php echo htmlspecialchars($product['name']); ?></td>

                        <!-- Product Description -->
                        <td><?php echo htmlspecialchars($product['description']); ?></td>

                        <!-- Product Price -->
                        <td><?php echo htmlspecialchars($product['price']); ?></td>

                        <!-- Product Stock -->
                        <td class="text-right"><?php echo htmlspecialchars($product['stock']); ?></td>

                        <!-- Product Image -->
                        <td>
                          <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                          <?php else: ?>
                            <span>No image</span>
                          <?php endif; ?>
                        </td>

                        <!-- Delete and Update Buttons -->
                        <td class="text-right">
                          <!-- Delete Button with Confirmation -->
                          <a href="ProductList.php?delete_product=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>


                          <!-- Update Button -->
                          <a href="UpdateProduct.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!--Weather API-->
        <div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Weather Information</h4>
      </div>
      <div class="card-body">
        <form method="GET" class="form-inline">
          <div class="form-group mb-2">
            <input type="text" name="city" class="form-control" placeholder="Enter a city" required>
          </div>
          <button type="submit" class="btn btn-primary mb-2 ml-2">Get Weather</button>
        </form>

        <?php if (isset($error)): ?>
          <p class="text-danger mt-3"><?php echo $error; ?></p>
        <?php elseif (isset($cityName)): ?>
          <div class="mt-4">
            <p><strong>City:</strong> <?php echo htmlspecialchars($cityName); ?></p>
            <p><strong>Temperature:</strong> <?php echo htmlspecialchars($temperature); ?> °C</p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


    <!--Footer Section-->
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul>
              <li><a href="https://www.creative-tim.com">Creative Tim</a></li>
              <li><a href="http://presentation.creative-tim.com">About Us</a></li>
              <li><a href="http://blog.creative-tim.com">Blog</a></li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
  &copy; <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script>, Designed by Invision. Coded by Creative Tim.
</div>
        </div>
      </footer>
    </div>
  </div>

  <script src="Assets/js/core/jquery.min.js"></script>
  <script src="Assets/js/core/popper.min.js"></script>
  <script src="Assets/js/core/bootstrap.min.js"></script>
  <script src="Assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="Assets/js/plugins/chartjs.min.js"></script>
  <script src="Assets/js/plugins/bootstrap-notify.js"></script>
  <script src="Assets/js/now-ui-dashboard.min.js?v=1.5.0"></script>
  <script src="Assets/demo/demo.js"></script>
</body>

</html>
