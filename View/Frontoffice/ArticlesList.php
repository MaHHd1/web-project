   <?php
   include '../../controller/ArticlesController.php';
   $articlesC = new ArticlesController();
   $list = $articlesC->listArticles();
   ?>
   <!DOCTYPE html>
   <html>
      <head>
         <!-- basic -->
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- mobile metas -->
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta name="viewport" content="initial-scale=1, maximum-scale=1">
         <!-- site metas -->
         <title>Shop</title>
         <meta name="keywords" content="">
         <meta name="description" content="">
         <meta name="author" content="">
         <!-- bootstrap css -->
         <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
         <!-- style css -->
         <link rel="stylesheet" type="text/css" href="css/style.css">
         <!-- Responsive-->
         <link rel="stylesheet" href="css/responsive.css">
         <!-- fevicon -->
         <link rel="icon" href="images/fevicon.png" type="image/gif" />
         <!-- font css -->
         <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800;1,400&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
         <!-- Scrollbar Custom CSS -->
         <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
         <!-- Tweaks for older IEs-->
         <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
         <style>
            .like-dislike-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

            </style>
      </head>
      <body>
         <div class="header_section">
            <div class="container-fluid">
               <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <a class="navbar-brand"href="index.html"><img src="images/logo.png"></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">


                  <li class="nav-item">
                     <a class="nav-link" href="../front_office/html/index.html">home</a>
                     </li>
                  
                     <li class="nav-item">
                     <a class="nav-link" href="../frontOffice2/index.php">event</a>
                     </li>
                  
                  
                     <li class="nav-item">
                        <a class="nav-link" href="../front_office/html/questionpage.php">question</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../frontend/index.php">cart</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="ArticlesList.php">article</a>
                     </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" href="../reclamations_view.php">reclamation </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../frontOffice2/profile.php">profile </a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  </form>
               </div>
               </nav>
            </div>
         </div>
         <!-- header section end -->
         <!-- layout_border start -->
         <div class="container-fluid">
            <div class="layout_border">
               <!-- vagetables section start -->
               <div class="vagetables_section layout_padding margin_bottom90">
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <h1 class="vagetables_taital">Our Articles</h1>
               <p class="vagetables_text">Here are some of the latest articles from our collection.</p>
            </div>
         </div>
         <div class="courses_section_2">
            <div class="row">
         
            <?php
            // Affichage des articles et commentaires
            foreach ($list as $article): ?>
               <div class="col-md-4">
                  <div class="hover01 column">
                  <figure>
               <img src="<?= '' . htmlspecialchars($article['contenu_img']) ?>" 
                     alt="Image de l'article" 
                     style="width:100%; height:200px; object-fit:cover;">
                     </figure>

                  </div>
                  
                  <!-- Titre et date de création -->
                  <h3 class="harshal_text"><?= htmlspecialchars($article['titre']) ?></h3>
                  <h3 class="rate_text"><?= htmlspecialchars($article['date_creation']) ?></h3>
                  
                  <!-- Contenu tronqué -->
                  <p><?= htmlspecialchars(substr($article['contenu_txt'], 0, 100)) ?>...</p>
                  
                  <!-- Bouton pour lire l'article en entier -->
                  <div class="read_bt_1">
                        <a href="article_details.php?id=<?= urlencode($article['id']) ?>">Read More</a>
                  </div>

                  <!-- Affichage des commentaires -->
                  <h4>Commentaires :</h4>
                  <ul class="comments-list">
                        <?php
                        $comments = $articlesC->showArticleWithComments($article['id'])['comments'];
                        if (!empty($comments)): 
                           foreach ($comments as $comment): ?>
                              <li>
                                    <?= htmlspecialchars($comment['comment_text']) ?> 
                                    <small><em>Ajouté le : <?= htmlspecialchars($comment['created_at']) ?></em></small>
                                    <br>
                              </li>
                           <?php endforeach; 
                        else: ?>
                           <p>Aucun commentaire pour cet article.</p>
                        <?php endif; ?>
                  </ul>
<!-- Boutons Like et Dislike -->
<div class="like-dislike-buttons">
   <form action="like_dislike.php" method="POST" style="display: inline;">
      <input type="hidden" name="article_id" value="<?= htmlspecialchars($article['id']) ?>">
      <input type="hidden" name="action" value="like">
      <button type="submit" class="btn btn-success">Like</button>
   </form>
   <form action="like_dislike.php" method="POST" style="display: inline;">
      <input type="hidden" name="article_id" value="<?= htmlspecialchars($article['id']) ?>">
      <input type="hidden" name="action" value="dislike">
      <button type="submit" class="btn btn-danger">Dislike</button>
   </form>
</div>
<!-- Affichage des comptes de Like et Dislike -->
<p>
   Likes : <?= htmlspecialchars($article['likes']) ?> |
   Dislikes : <?= htmlspecialchars($article['dislikes']) ?>
</p>

                  <!-- Formulaire pour ajouter un commentaire -->
                  <form action="addcomment.php" method="POST">
                        <input type="hidden" name="article_id" value="<?= htmlspecialchars($article['id']) ?>">
                        <div class="form-group">
                           <label for="comment">Ajouter un commentaire :</label>
                           <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter le commentaire</button>
                  </form>
               </div>
            <?php endforeach; ?>


            </div>
         </div>
      </div>
   </div>
               <!-- vagetables section end -->
               <!-- layout_border end -->
            </div>
         </div>
         <!-- footer section start -->
         <div class="footer_section layout_padding">
            <div class="container">
               <div class="row">
                  <div class="col-lg-4 col-sm-6">
                     <h3 class="footer_text">Useful links</h3>
                     <div class="footer_menu">
                        <ul>
                           <li class="active"><a href="index.html"><span class="angle_icon active"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a></li>
                           <li><a href="about.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  About</a></li>
                           <li><a href="services.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Services</a></li>
                           <li><a href="domain.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Domain</a></li>
                           <li><a href="testimonial"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Testimonial</a></li>
                           <li><a href="contact.html"><span class="angle_icon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>  Contact Us</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <h3 class="footer_text">Address</h3>
                     <div class="location_text">
                        <ul>
                           <li>
                              <a href="#">
                              <span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>It is a long established fact that a<br> reader will be distracted</a>
                           </li>
                           <li>
                              <a href="#">
                              <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>(+71) 1234567890<br>(+71) 1234567890
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>demo@gmail.com
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-4 col-sm-6">
                     <div class="footer_main">
                        <h3 class="footer_text">Find Us</h3>
                        <p class="dummy_text">more-or-less normal distribution </p>
                        <div class="social_icon">
                           <ul>
                              <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                              <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
           <!-- Formulaire pour liker -->
           <form method="POST" action="../public/like.php">
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
                <button type="submit">👍 Liker</button>
            </form>
         <!-- footer section end -->
         <!-- copyright section start -->
         <div class="copyright_section">
            <div class="container">
               <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free html  Templates</a></p>
            </div>
         </div>
         <!-- copyright section end -->
         <!-- Javascript files-->
         <script>
      // Lorsque le formulaire est soumis
      document.getElementById('commentForm').addEventListener('submit', function(event) {
         event.preventDefault();  // Empêcher le formulaire de se soumettre normalement

         var formData = new FormData(this);  // Récupérer les données du formulaire

         // Créer une requête AJAX
         var xhr = new XMLHttpRequest();
         xhr.open("POST", this.action, true);

         // Lorsqu'une réponse est reçue
         xhr.onload = function () {
               if (xhr.status === 200) {
                  // Si la requête est réussie, afficher le commentaire
                  var response = JSON.parse(xhr.responseText);
                  if (response.success) {
                     var commentHtml = '<li>' + response.comment_text + '</li>';
                     document.querySelector('.comments-list').innerHTML += commentHtml;  // Ajouter le commentaire à la liste
                     document.getElementById('comment').value = '';  // Réinitialiser le champ de texte
                  } else {
                     alert('Erreur lors de l\'ajout du commentaire');
                  }
               }     
         };

         // Envoyer la requête
         xhr.send(formData);
      });
   </script>
      



      <script>
document.addEventListener('DOMContentLoaded', function () {
    // Récupérer les paramètres de l'URL
    const urlParams = new URLSearchParams(window.location.search);

    // Vérifier si 'notification=success' est dans l'URL
    if (urlParams.get('notification') === 'success') {
        if (Notification.permission === 'granted') {
            new Notification('Succès', { body: 'Votre commentaire a été ajouté avec succès.' });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    new Notification('Succès', { body: 'Votre commentaire a été ajouté avec succès.' });
                }
            });
        }
        
        // Nettoyer l'URL en supprimant le paramètre 'notification'
        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});
</script>

         <script src="js/jquery.min.js"></script>
         <script src="js/popper.min.js"></script>
         <script src="js/bootstrap.bundle.min.js"></script>
         <script src="js/jquery-3.0.0.min.js"></script>
         <script src="js/plugin.js"></script>
      </body>
   </html>