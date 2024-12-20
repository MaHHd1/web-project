<?php
require_once '../../Controller/CartController.php';


// Check if the product_id is passed via GET and is a valid number
if (isset($_GET['product_id']) && !empty($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $productId = intval($_GET['product_id']); // Sanitize and convert to integer
    $quantity = 1; // Default quantity to add

    // Create an instance of the Database class and get the PDO connection
    $database = new Database();
    $pdo = $database->connect();

    // Check if the connection is successful
    if ($pdo === null) {
        die("Database connection failed!");
    }

    // Check if the product already exists in the cart
    $query = "SELECT * FROM cart WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // If the product exists, increment the quantity
        $newQuantity = $cartItem['quantity'] + $quantity;
        $updateQuery = "UPDATE cart SET quantity = :quantity WHERE product_id = :product_id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $updateStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            header('Location: Cart.php');
            exit();
        } else {
            echo "Failed to update product quantity in the cart.";
        }
    } else {
        // If the product does not exist, add it to the cart
        $insertQuery = "INSERT INTO cart (product_id, quantity) VALUES (:product_id, :quantity)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            header('Location: Cart.php');
            exit();
        } else {
            echo "Failed to add product to the cart.";
        }
    }
}
 

?>
