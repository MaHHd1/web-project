<?php

// Replace this with your actual API Key and URL endpoint
define('API_URL', 'https://api.yara.com/fertilizer-recommendation'); // Example URL
define('API_KEY', 'your_yara_api_key');

// Function to make an API request to Yara or another service
function getFertilizerRecommendation($cropType, $soilHealth, $environmentalFactors) {
    // Initialize cURL session
    $ch = curl_init();
    
    // Set the URL with query parameters (Example: Crop type, soil health, etc.)
    $url = API_URL . "?crop=" . urlencode($cropType) .
           "&soil=" . urlencode($soilHealth) .
           "&env=" . urlencode($environmentalFactors);
    
    // Set headers (Authorization is commonly required)
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . API_KEY,
    ];
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    // Execute the request and store the response
    $response = curl_exec($ch);
    
    // Check if any error occurred
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    
    // Close the cURL session
    curl_close($ch);
    
    // Decode the JSON response into an array
    return json_decode($response, true);
}

// Get inputs from the user (example inputs from a form)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cropType = $_POST['cropType'];
    $soilHealth = $_POST['soilHealth'];
    $environmentalFactors = $_POST['environmentalFactors'];
    
    // Call the API function with the user input
    $fertilizerRecommendation = getFertilizerRecommendation($cropType, $soilHealth, $environmentalFactors);
    
    // Process the recommendation (this is just an example, format as needed)
    if (isset($fertilizerRecommendation['recommendations'])) {
        echo "Recommended Fertilizers for $cropType: <br>";
        foreach ($fertilizerRecommendation['recommendations'] as $recommendation) {
            echo $recommendation['name'] . " - " . $recommendation['dosage'] . " per hectare <br>";
        }
    } else {
        echo "No recommendations available at the moment.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fertilizer Recommendation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Fertilizer Recommendation</h1>
        <form action="FertilizerAPI.php" method="POST">
            <div class="form-group">
                <label for="cropType">Crop Type</label>
                <input type="text" class="form-control" id="cropType" name="cropType" placeholder="Enter crop type (e.g., Corn)" required>
            </div>
            <div class="form-group">
                <label for="soilHealth">Soil Health</label>
                <input type="text" class="form-control" id="soilHealth" name="soilHealth" placeholder="Enter soil health (e.g., pH level)" required>
            </div>
            <div class="form-group">
                <label for="environmentalFactors">Environmental Factors</label>
                <input type="text" class="form-control" id="environmentalFactors" name="environmentalFactors" placeholder="Enter environmental factors (e.g., temperature, rainfall)" required>
            </div>
            <button type="submit" class="btn btn-primary">Get Recommendation</button>
        </form>
    </div>

    <!-- Optionally include Bootstrap JS and jQuery for form enhancements -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>