<?php

include '../../controller/ArticleController.php';

$error = "";
$offer = null;

// create an instance of the controller
$offerController = new ArticleController();

if (
  isset($_POST["titre"]) && 
  isset($_POST["contenu_txt"]) && 
  isset($_FILES["contenu_img"]) && 
  isset($_POST["date_creation"])
) {
  if (
      !empty($_POST["titre"]) && 
      !empty($_POST["contenu_txt"]) && 
      !empty($_POST["date_creation"])
  ) {
    // Gestion du fichier image
    $imageData = null;
    if (!empty($_FILES['contenu_img']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['contenu_img']['tmp_name']);
    } elseif (isset($article['contenu_img'])) {
        // Conserver l'image existante si aucun fichier n'est uploadé
        $imageData = $article['contenu_img'];
    }
          // Encodage de l'image
          $imageContent = file_get_contents($_FILES["contenu_img"]["tmp_name"]);
          $imageBase64 = base64_encode($imageContent);

          // Création de l'article
          $offer = new Article(
              null,
              $_POST['titre'],
              $_POST['contenu_txt'],
              $imageBase64,
              new DateTime($_POST['date_creation'])
          );

          // Ajout à la base de données
          $offerController->addArticle($offer);

          // Redirection
          header('Location:ArticleList.php');
          exit;
  } else {
      $error = "Informations manquantes";
  }
} else {
  $error = "Formulaire invalide";
}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f8f9fa;
        font-family: 'Nunito', sans-serif;
      }
      .form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
      }
      .form-container h1 {
        font-weight: 700;
        font-size: 28px;
        margin-bottom: 20px;
        color: #343a40;
      }
      .form-label {
        font-weight: 600;
        color: #495057;
      }
      .btn-primary {
        background-color: #5cb85c;
        border-color: #5cb85c;
      }
      .btn-primary:hover {
        background-color: #4cae4c;
        border-color: #4cae4c;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
        <h1 class="mb-4">Ajouter un article</h1>
        <form action="add_article.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Contenu</label>
        <textarea class="form-control" id="content" name="contenu_txt" rows="5" required></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="contenu_img" accept="image/*" required>
    </div>
    <div class="mb-3">
        <label for="date_creation" class="form-label">Date de création</label>
        <input type="date" class="form-control" id="date_creation" name="date_creation" required>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

    </div>
  </body>
</html>
