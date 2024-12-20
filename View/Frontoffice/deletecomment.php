<?php
include '../../controller/CommentaireController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_comment'])) { // Vérifier avec la clé correcte
    $commentairesController = new CommentaireController();
    $id = (int)$_POST['id_comment']; // Conversion explicite pour plus de sécurité


    echo "ID du commentaire : " . $id;
    if ($commentairesController->deleteCommentaire($id)) {
        header("Location: ArticlesList.php");
        exit;
    } else {
        echo "Erreur : impossible de supprimer le commentaire.";
    }
} else {
    echo "Requête invalide ou ID manquant.";
}
?>
