<?php
require_once '../../Controller/ProduitsController.php';
//verification si idp est mawjoud dans l'url
if (isset($_GET['idP']) && $_GET['idP'] != '') {
    //la supp de produit a travers lid de bd
    $Pc = new ProduitsController();
    $Pc->deleteProduit($_GET['idP']);
    header('Location: index.php');
    exit();
}
?>