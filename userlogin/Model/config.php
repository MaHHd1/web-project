<?php
$host = '127.0.0.1';   // Localhost (default XAMPP MySQL address)
$dbname = 'db';         // Database name (created in phpMyAdmin)
$username = 'root';     // Default MySQL username in XAMPP
$password = '';         // Default MySQL password in XAMPP (blank)

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // If connection fails, display the error
    echo "Connection failed: " . $e->getMessage();
}
?>
