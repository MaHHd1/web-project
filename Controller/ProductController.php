<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // Fetch and display all products
    public function index()
    {
        return $this->productModel->getAllProducts();
    }

    // Add a new product
    public function addProduct($data)
    {
        // Perform validation here if necessary
        if ($this->validateProductData($data)) {
            return $this->productModel->addProduct($data);
        } else {
            // Handle validation error
            header("Location: products.php?status=error&message=InvalidData");
            exit();
        }
    }

    // Update an existing product
    public function updateProduct($id, $data)
    {
        if ($id && !empty($data)) {
            // Validate the data before updating
            if ($this->validateProductData($data)) {
                $result = $this->productModel->updateProduct($id, $data);
    
                if ($result) {
                    header("Location: ProductList.php?status=updated");
                    exit();
                } else {
                    header("Location: ProductList.php?status=error&message=UpdateFailed");
                    exit();
                }
            } else {
                // Log validation failure for debugging
                error_log("Validation failed for product update. Data: " . print_r($data, true));
                header("Location: ProductList.php?status=error&message=InvalidData");
                exit();
            }
        } else {
            // Log missing ID or data for debugging
            error_log("Update failed: Missing ID or data. ID: $id, Data: " . print_r($data, true));
            header("Location: ProductList.php?status=error&message=MissingID");
            exit();
        }
    }
    

    // Delete a product
    public function deleteProduct($id)
    {
        if ($id) {
            $this->productModel->deleteProduct($id);
            header("Location: ProductList.php?status=deleted");
            exit();
        } else {
            header("Location: ProductList.php?status=error&message=MissingID");
            exit();
        }
    }

    // Validate product data (name, description, price, etc.)
    private function validateProductData($data)
    {
        return isset($data['name'], $data['description'], $data['price'], $data['stock'], $data['image'])
            && !empty($data['name'])
            && !empty($data['description'])
            && is_numeric($data['price']) && $data['price'] > 0
            && is_numeric($data['stock']) && $data['stock'] >= 0;
    }
}

// Handle form submissions or actions
$productController = new ProductController();

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $newProduct = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
        'image' => $_POST['image']
    ];
    $productController->addProduct($newProduct);
}

// Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $updatedProduct = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
        'image' => $_POST['image']
    ];
    $productController->updateProduct($id, $updatedProduct);
}

// Delete product
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    $productController->deleteProduct($id);
    return $productModel->deleteProductById($id);
}
?>
