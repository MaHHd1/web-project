<?php
include '../../controller/ArticleController.php';
$articleC = new ArticleController();
$articleC->deleteArticle($_GET["id"]);
header('Location:tables.php');
