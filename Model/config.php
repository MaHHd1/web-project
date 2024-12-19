<?php
$host = 'localhost';
$dbname = 'db'; // Replace 'db' with your actual database name
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Success message
    //echo "Connected to the database successfully!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>


