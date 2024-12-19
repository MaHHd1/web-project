<?php
include '../../controller/ProduitController.php'; // Include your controller
include '../../controller/CartController.php'; // Include cart handling logic

$produitController = new ProduitController();
$list = $produitController->getAllProduits(); // Retrieve all products
?>