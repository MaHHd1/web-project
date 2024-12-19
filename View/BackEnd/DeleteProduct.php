<?php
require_once '../../Controller/ProductController.php';

// Instantiate the controller
$productController = new ProductController();

// Check if the 'delete_product' parameter is present in the URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_product'])) {
    $id = $_GET['delete_product']; // Get the product ID from the URL

    // Call the controller's deleteProduct method to delete the product by ID
    if ($productController->deleteProduct($id)) {
        // Redirect back to the product list page after successful deletion
        header('Location: ProductList.php');
        exit;
    } else {
        echo '<p style="color: red;">Failed to delete the product.</p>';
    }
}
?>
