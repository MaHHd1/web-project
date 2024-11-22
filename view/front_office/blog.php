<?php
include '../../controller/ArticleController.php';
$articleC = new ArticleController();

// Appel à la méthode correcte pour récupérer les articles
$list = $articleC->listArticle();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Organic - Grocery Store HTML Website Template</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  </head>
  <body>
  <section id="latest-blog" class="pb-4">
    <div class="container-lg">
        <!-- Header Section -->
        <div class="row">
            <div class="section-header d-flex align-items-center justify-content-between my-4">
                <h2 class="section-title">Our Recent Blog</h2>
                <a href="add_article.php" class="btn btn-success">Add Article</a>
            </div>
        </div>

        <!-- Articles List -->
        <div class="row">
            <?php foreach ($list as $article): ?>
                <div class="col-md-4">
                    <article class="post-item card border-0 shadow-sm p-3">
                        <div class="image-holder zoom-effect">
                            <?php
                            // Vérifier si une image est associée à l'article
                            if ($article['contenu_img']) {
                                // Convertir l'image en base64 et l'afficher dans un tag <img>
                                $imageData = base64_encode($article['contenu_img']); // On s'assure que l'image est en base64
                                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="post" class="card-img-top">';
                            } else {
                                // Image par défaut si aucune image n'est associée
                                echo '<img src="images/default-thumbnail.jpg" alt="post" class="card-img-top">';
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                                <div class="meta-date">
                                    <svg width="16" height="16"><use xlink:href="#calendar"></use></svg>
                                    <?= date('d M Y', strtotime($article['date_creation'])) ?>
                                </div>
                            </div>
                            <div class="post-header">
                                <h3 class="post-title">
                                    <a href="#" class="text-decoration-none"><?= htmlspecialchars($article['titre']) ?></a>
                                </h3>
                                <p><?= htmlspecialchars(substr($article['contenu_txt'], 0, 100)) ?>...</p>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
