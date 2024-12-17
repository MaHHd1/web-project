<?php
$commentId = $_GET['id'];
$comment = $commentsC->getCommentById($commentId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedText = $_POST['comment'];
    $commentsC->updateCommentaire($commentId, $updatedText);
    header('Location: article_details.php?id=' . urlencode($comment['article_id']));
    exit;
}
?>

<!-- Formulaire pour mettre à jour un commentaire -->
<form action="" method="POST">
    <label for="comment">Modifier le commentaire :</label>
    <textarea name="comment" id="comment" rows="4" required><?= htmlspecialchars($comment['comment_text']) ?></textarea>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
