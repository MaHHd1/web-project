<?php

require_once __DIR__ . '/../database.php';


class CartController
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connect();
    }

    /**
     * Add a product to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addToCart($productId, $quantity = 1)
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
     * Get all products in the cart.
     *
     * @return array
     */
    public function getCart()
    {
        try {
            $query = "SELECT cart.id, product.name, product.price, cart.quantity,
                      (product.price * cart.quantity) AS total_price
                      FROM cart
                      JOIN product ON cart.product_id = product.id";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching cart: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $cartId
     * @return bool
     */
    public function removeFromCart($cartId)
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
}
?>
