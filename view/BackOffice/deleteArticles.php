<?php
include '../../controller/ArticlesController.php';
$articlesC = new ArticlesController();
$articlesC->deleteArticles($_GET["id"]);
header('Location:listArticles.php');
