<?php

require_once '../database.php';

class CartModel
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connect();
    }

    /**
     * Add a product to the cart or update the quantity if the product already exists.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addProduct($productId, $quantity = 1)
    {
        try {
            $query = "INSERT INTO cart (product_id, quantity) VALUES (:product_id, :quantity)
                      ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error adding product to cart: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retrieve all items in the cart with product details.
     *
     * @return array
     */
    public function getCartItems()
    {
        try {
            $query = "SELECT cart.id, product.name, product.price, cart.quantity,
                             (product.price * cart.quantity) AS total_price
                      FROM cart
                      JOIN product ON cart.product_id = product.id";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching cart items: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Remove a specific product from the cart by cart ID.
     *
     * @param int $cartId
     * @return bool
     */
    public function removeProduct($cartId)
    {
        try {
            $query = "DELETE FROM cart WHERE id = :cart_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error removing product from cart: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Clear all items in the cart.
     *
     * @return bool
     */
    public function clearCart()
    {
        try {
            $query = "DELETE FROM cart";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error clearing cart: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Get the total cost of the items in the cart.
     *
     * @return float
     */
    public function getTotalCost()
    {
        try {
            $query = "SELECT SUM(product.price * cart.quantity) AS total_cost
                      FROM cart
                      JOIN product ON cart.product_id = product.id";
            $stmt = $this->pdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_cost'] ?? 0.0;
        } catch (PDOException $e) {
            echo "Error calculating total cost: " . $e->getMessage();
            return 0.0;
        }
    }
}
?>
