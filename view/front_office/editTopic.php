<?php
// Le sujet à modifier est déjà récupéré dans le contrôleur
?>

<div class="new_topic_form">
    <h2 class="forum_heading">Modifier le sujet</h2>
    <form method="POST" action="">
        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($topic['title']); ?>" required />
        <textarea class="form-control" name="content" rows="5" required><?php echo htmlspecialchars($topic['content']); ?></textarea>
        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>
