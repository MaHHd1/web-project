<?php
require_once 'weather.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the uploaded images
    if (isset($_FILES['images'])) {
        $images = $_FILES['images'];
        
        // You can process images, or send them to the Crop Health API later
    }

    // Collect the form data
    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $similar_images = isset($_POST['similar_images']) ? true : false;
    $datetime = $_POST['datetime'] ?? '';
    $custom_id = $_POST['custom_id'] ?? '';

    // Crop Health API URL and API Key
    $api_url = 'https://crop.kindwise.com/api/v1/identify';
    $api_key = 'your_api_key_here';

    // Prepare the request data
    $data = [
        'images' => [], // You will need to convert the uploaded images to base64 or send them as files
        'latitude' => $latitude,
        'longitude' => $longitude,
        'similar_images' => $similar_images,
        'datetime' => $datetime,
        'custom_id' => $custom_id
    ];

    // If using multipart/form-data to send images
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    // Attach the form data to the request
    $post_fields = [
        'latitude' => $latitude,
        'longitude' => $longitude,
        'similar_images' => $similar_images ? 'true' : 'false',
        'datetime' => $datetime,
        'custom_id' => $custom_id
    ];

    // Attach the images to the request (converted to base64 or as files)
    foreach ($images['tmp_name'] as $index => $tmp_name) {
        $base64_image = base64_encode(file_get_contents($tmp_name));
        $post_fields['images[]'] = $base64_image;
    }

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    // Set headers, including the API key for authorization
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: multipart/form-data'
    ]);

    // Execute the request and get the response
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    
    // Close cURL session
    curl_close($ch);

    // Decode the JSON response from the API
    $result = json_decode($response, true);

    // Now display the results
    if (isset($result['result']['crop']['suggestions'])) {
        echo "<h3>Suggested Crops:</h3>";
        foreach ($result['result']['crop']['suggestions'] as $suggestion) {
            echo "<p>Name: " . $suggestion['name'] . "</p>";
            echo "<p>Scientific Name: " . $suggestion['scientific_name'] . "</p>";
            echo "<p>Probability: " . $suggestion['probability'] . "%</p>";
        }
    }

    if (isset($result['result']['disease']['suggestions'])) {
        echo "<h3>Suggested Diseases:</h3>";
        foreach ($result['result']['disease']['suggestions'] as $disease) {
            echo "<p>Name: " . $disease['name'] . "</p>";
            echo "<p>Scientific Name: " . $disease['scientific_name'] . "</p>";
            echo "<p>Probability: " . $disease['probability'] . "%</p>";
        }
    }

    // You can display more details based on the API response as needed.
}
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
          <li>
            <a href="ProductList.php">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Product List</p>
            </a>
          </li>
          <li class="active">
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
        <!-- Crop Health Identification -->
<div class="container">
    <h1 class="mt-5">Crop Health Identification</h1>
    <form action="CropHealthAPI.php" method="POST" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Upload Crop Images</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="images" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Crop Images (multiple allowed)
                    </label>
                    <input type="file" name="images[]" id="images" class="form-control-file" multiple required style="display: none;">
                </div>

                
                <div class="form-group">
    <label for="map">Select Location:</label>
    <div id="map" style="height: 400px; width: 100%;"></div>
    <input type="hidden" name="latitude" id="latitude" class="form-control" placeholder="Latitude">
    <input type="hidden" name="longitude" id="longitude" class="form-control" placeholder="Longitude">
</div>
                <div class="form-group">
                    <label for="similar_images">Include Similar Images:</label>
                    <input type="checkbox" name="similar_images" id="similar_images" value="true">
                </div>
                <div class="form-group">
                    <label for="datetime">Date and Time (optional):</label>
                    <input type="text" name="datetime" id="datetime" class="form-control" placeholder="Enter date (e.g., 2023-06-22)">
                </div>
                <div class="form-group">
                    <label for="custom_id">Custom ID (optional):</label>
                    <input type="text" name="custom_id" id="custom_id" class="form-control" placeholder="Enter custom ID">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- Weather Information -->
<div class="container mt-5">
    <h1>Weather Information</h1>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Get Weather Information</h4>
        </div>
        <div class="card-body">
            <form method="GET" class="form-inline">
                <div class="form-group mb-2">
                    <input type="text" name="city" class="form-control" placeholder="Enter a city" required>
                </div>
                <button type="submit" class="btn btn-primary mb-2 ml-2">Get Weather</button>
            </form>
            <?php if (isset($error)): ?>
                <p class="error text-danger mt-3"><?php echo $error; ?></p>
            <?php elseif (isset($cityName)): ?>
                <div class="weather-result mt-3">
                    <p><strong>City:</strong> <?php echo $cityName; ?></p>
                    <p><strong>Temperature:</strong> <?php echo $temperature; ?> °C</p>
                    <p><strong>Description:</strong> <?php echo $description; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


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
  <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_3pwO3TIhW5aaScka4EW0ohUWQ4KzCBw&loading=async&callback=initMap">
</script>
  <script src="Assets/js/Maps.js"></script>
</body>

</html>