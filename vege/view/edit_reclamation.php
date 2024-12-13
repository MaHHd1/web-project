<?php
require_once '../config/DbConfig.php';
require_once '../controller/ReclamationController.php';

$reclamationController = new ReclamationController();

if (isset($_GET['id'])) {
    $reclamationId = $_GET['id'];
    $reclamation = $reclamationController->getById($reclamationId); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reclamationId = $_POST['reclamationId'];
    $utilisateurId = $_POST['utilisateurId'];
    $description = $_POST['content'];
    $note = $_POST['note'];
    $produitId = $_POST['produitId'];

    $reclamationController->update($reclamationId,$utilisateurId,$produitId,$note, $description);
    header('Location: reclamations_manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reclamation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Reclamation</h2>
        <form action="" method="post">
            <input type="hidden" name="reclamationId" value="<?= $reclamation->getId() ?>">
            <input type="hidden" name="utilisateurId" value="<?= $reclamation->getUtilisateurId() ?>">
            <input type="hidden" name="produitId" value="<?= $reclamation->getProduitId() ?>">
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="content" class="form-control" rows="3"><?= $reclamation->getContent() ?></textarea>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="number" id="note" name="note" class="form-control" value="<?= $reclamation->getNote() ?>" min="1" max="5">
            </div>
            <button type="submit" class="btn btn-success">Update Reclamation</button>
            <a href="reclamations_manage.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>