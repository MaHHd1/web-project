<?php
include '../../controller/ProduitController.php';
$produitC = new ProduitController();
$produitC->deleteProduit($_GET["id"]);
header('Location:tables.php');
