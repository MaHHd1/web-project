<?php
require_once '../../Controller/CartController.php';

if (isset($_GET['cart_id']) && !empty($_GET['cart_id'])) {
    $cartId = intval($_GET['cart_id']);
    $cartController = new CartController();

    if ($cartController->removeFromCart($cartId)) {
        header('Location: Cart.php');
        exit();
    } else {
        echo "Failed to remove the item from the cart.";
    }
} else {
    echo "Invalid cart ID.";
}
?>
