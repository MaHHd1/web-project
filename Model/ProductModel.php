<?php
require_once __DIR__ . '../../database.php';

class ProductModel {
    private $conn;

    public function __construct() {
        // Establish database connection
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * Fetch all products from the database.
     *
     * @return array List of all products.
     */
    public function getAllProducts() {
        $query = "SELECT * FROM product";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a single product by ID.
     *
     * @param int $id Product ID.
     * @return array Product details.
     */
    public function getProductById($id) {
        $query = "SELECT * FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new product to the database.
     *
     * @param array $data Product details (name, description, price, stock, image).
     * @return bool Operation success or failure.
     */
    public function addProduct($data) {
        $query = "INSERT INTO product (name, description, price, stock, image) 
                  VALUES (:name, :description, :price, :stock, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    }

    /**
     * Update an existing product in the database.
     *
     * @param int $id Product ID.
     * @param array $data Updated product details.
     * @return bool Operation success or failure.
     */
    public function updateProduct($id, $data) {
        $query = "UPDATE product 
                  SET name = :name, description = :description, price = :price, stock = :stock, image = :image 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    }

    /**
     * Delete a product from the database.
     *
     * @param int $id Product ID.
     * @return bool Operation success or failure.
     */
    public function deleteProduct($id) {
        $query = "DELETE FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
