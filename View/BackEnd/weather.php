<?php
// Your API key from OpenWeatherMap
$apiKey = '59d7acb8803d45e2916285ecd90a6e6c'; // Replace with your OpenWeatherMap API key
$defaultCity = 'Madrid'; // Default city if none is provided

// Get the city from the form input or use the default city
$city = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : $defaultCity;

// OpenWeatherMap API URL
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$apiKey}&lang=en";

// Fetch the weather data
$response = @file_get_contents($apiUrl);
$weatherData = $response ? json_decode($response, true) : null;

// Handle errors
if (!$weatherData || $weatherData['cod'] != 200) {
    $error = "City not found or unable to fetch weather data.";
} else {
    $temperature = $weatherData['main']['temp'];
    $description = ucfirst($weatherData['weather'][0]['description']);
    $cityName = $weatherData['name'];
}
?>

