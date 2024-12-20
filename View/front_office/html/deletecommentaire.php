<?php
include_once '../../../controller/commentaireC.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $commentaireC = new CommentaireC();
    if ($commentaireC->deleteCommentaire($id)) {
        echo "<script>
                alert('Commentaire deleted successfully!');
                window.location.href = 'listcommentaire.php';
              </script>";
    } else {
        echo "<script>
                alert('Unable to delete commentaire.');
                window.location.href = 'listcommentaire.php';
              </script>";
    }
}
?>
