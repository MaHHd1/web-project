<?php
include '../../controller/ArticlesController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($articleId && in_array($action, ['like', 'dislike'])) {
        $articlesC = new ArticlesController();
        if ($articlesC->updateLikeDislike($articleId, $action)) {
            header("Location: {$_SERVER['HTTP_REFERER']}"); // Redirection à la page précédente
            exit;
        } else {
            echo "Erreur lors de la mise à jour des likes/dislikes.";
        }
    } else {
        echo "Paramètres invalides.";
    }
} else {
    echo "Méthode non autorisée.";
}
