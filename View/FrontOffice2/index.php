<?php
require_once '../../Controller/ProduitsController.php';
require_once '../../Controller/LoginController.php';
session_start();

$Pc = new ProduitsController();

// Configuration de la pagination
$limit = 6; // Nombre de produits par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
$start = ($page - 1) * $limit; // Début des résultats à afficher

// Gestion des filtres et tri
$filter = isset($_GET['filter']) ? htmlspecialchars(trim($_GET['filter'])) : '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchTerm = htmlspecialchars(trim($_GET['search']));
    $tabP = $Pc->searchProduitsByName($searchTerm, $start, $limit);
    $totalProduits = count($Pc->searchProduitsByName($searchTerm, 0, 0));
} else {
    switch ($filter) {
        case 'price_asc':
            $tabP = $Pc->listProduitsByPrice('ASC', $start, $limit);
            break;
        case 'price_desc':
            $tabP = $Pc->listProduitsByPrice('DESC', $start, $limit);
            break;
        case 'date_closest':
            $tabP = $Pc->listProduitsByDateClosest($start, $limit);
            break;
            case 'date_closest':
                $tabP = $Pc->listProduitsByDateClosest($start, $limit);
                break;

        default:
            $tabP = $Pc->listProduitPaginated($start, $limit);
    }
    $totalProduits = count($Pc->listProduit());
}

$totalPages = ceil($totalProduits / $limit);
?>
<!DOCTYPE html>
<html lang="fr">
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,800;1,400&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        /* Navbar Styles */
        /*.navbar {
            background-color: #28a745;
        }
        .navbar .nav-link {
            color: white !important;
            font-weight: bold;
        }
        .navbar .nav-link:hover {
            color: #d4edda !important;
        }
        /* Footer Styles */
        .footer_section {
            background-color: #000;
            color: white;
            padding: 20px 0;
        }
        .footer_section h3, .footer_section ul {
            color: white;
        }
        .footer_section ul li a {
            color: white;
            text-decoration: none;
        }
        .footer_section ul li a:hover {
            color: #28a745;
        }
        .social_icon a {
            color: white;
            font-size: 30px;
            margin-right: 20px;
            padding: 15px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff5c8d, #28a745);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .social_icon a:hover {
            transform: scale(1.2);
            background: linear-gradient(45deg, #28a745, #ff5c8d);
        }
        .social-icon-twitter {
            background-color: #00acee;
        }
        .social-icon-instagram {
            background-color: #8a3ab9;
        }
        /* Centrer horizontalement */
.vagetables_taital, .vagetables_text {
    text-align: center;
}

/* Si vous souhaitez centrer verticalement et horizontalement dans un conteneur parent */
.parent-container {
    display: flex;
    justify-content: center;  /* Centrer horizontalement */
    align-items: center;      /* Centrer verticalement */
    height: 100vh;
    text-align: center;          /* Hauteur du conteneur pour occuper toute la hauteur de l'écran */
}

/* Exemple de style pour le titre et le texte */
.vagetables_taital {
    font-size: 2rem;  /* Ajustez la taille de la police du titre */
    margin-bottom: 10px;
    text-align: center;
}

.vagetables_text {
    font-size: 1rem;  /* Ajustez la taille de la police du texte */
    max-width: 600px; /* Vous pouvez ajuster la largeur pour mieux contrôler l'apparence */
    text-align: center;
}

        /* Product Section Styles */
         /* Animations */
    @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(200px); } 100% { opacity: 1; transform: translateY(0); } }
    @keyframes hoverZoom { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

    /* Product Card */
    .product-card { border: 1px solid #ddd; border-radius: 10px; transition: transform 0.3s, box-shadow 0.3s; animation: fadeInUp 0.6s ease-out; background: linear-gradient(145deg, #ffffff, #f3f3f3); box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px rgba(255, 255, 255, 0.7); }
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
    .product-card img { border-top-left-radius: 10px; border-top-right-radius: 10px; height: 200px; object-fit: cover; transition: transform 0.3s ease; }
    .product-card:hover img { animation: hoverZoom 0.5s ease-in-out; }

    /* Product Details */
    .product-details { padding: 15px; text-align: center; }
    .product-details h5 { font-size: 1.2rem; color: #333; font-weight: 600; transition: color 0.3s; }
    .product-details p { font-size: 0.9rem; color: #666; transition: color 0.3s; }
    .product-details i { color: #28a745; margin-right: 8px; }

    /* Button Styles */
    .btn-primary { background-color: #28a745; border: none; transition: background-color 0.3s ease; font-weight: 600; }
    .btn-primary:hover { background-color: #1e7e34; }

    /* Social Media Share Icons */
    .social-icon a { color: white; font-size: 30px; margin-right: 15px; padding: 10px; border-radius: 50%; background: linear-gradient(45deg, #ff5c8d, #28a745); transition: transform 0.3s ease, background 0.3s ease; }
    .social-icon a:hover { transform: scale(1.2); background: linear-gradient(45deg, #28a745, #ff5c8d); }
    .social-icon-twitter { background-color: #00acee; }
    .social-icon-instagram { background-color: #8a3ab9; }
    </style>
</head>
<body>

<!-- Navbar -->
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
                     <a class="nav-link" href="index.php">event</a>
                     </li>
                  
                  
                     <li class="nav-item">
                        <a class="nav-link" href="../front_office/html/questionpage.php">question</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../frontend/index.php">cart</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../Frontoffice/ArticlesList.php">article</a>
                     </li>
                    
                     <li class="nav-item">
                        <a class="nav-link" href="../reclamations_view.php">reclamation </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="profile.php">profile </a>
                     </li>
                  </ul>
                  <form class="form-inline my-2 my-lg-0">
                     <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  </form>
               </div>
            </nav>
         </div>
      </div>


      <p>.</p>
<!-- Section for Search and Filter Buttons -->
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <!-- Filter Form -->
        <form method="GET" action="index.php" class="d-flex">
            <input type="hidden" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <select name="filter" class="form-select me-2">
                <option value="">-- Trier par --</option>
                <option value="price_asc" <?= $filter === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option>
                <option value="price_desc" <?= $filter === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                <option value="date_closest" <?= $filter === 'date_closest' ? 'selected' : '' ?>>Date la plus proche</option>
            </select>
            <button class="btn btn-outline-success" type="submit">Filtrer</button>
        </form>
        <!-- Search Form -->
        <form class="d-flex justify-content-end ms-3" method="GET" action="index.php">
            <div class="input-group">
                <input
                    class="form-control"
                    type="search"
                    name="search"
                    placeholder="Rechercher un événement"
                    aria-label="Search"
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                >
                <button class="btn btn-outline-success" type="submit">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
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
                     <h1 class="vagetables_taital">Our Events</h1>
<p class="vagetables_text">Passages of Lorem Ipsum available, but the majority have suffered alteration</p>

                     </div>
                  </div>
                  <div class="row">
        <?php foreach ($tabP as $produit): ?>
            <div class="col-md-4">
                <div class="product-card">
                    <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>" class="w-100">
                    <div class="product-details">
                    <h5><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($produit['lieu']); ?></p>
                        <p><i class="fas fa-calendar-alt"></i> Début: <?= htmlspecialchars($produit['date']); ?></p>
                        <p><i class="fas fa-calendar-check"></i> Fin: <?= htmlspecialchars($produit['datef']); ?></p>
                        <p><i class="fas fa-tag"></i> $<?= htmlspecialchars($produit['pass']); ?></p>
                        <a href="../BackOffice/reserver.php?id=<?= $produit['id'] ?>" class="btn btn-primary">Réserver</a>
<style>
    .like-btn { background: none; border: none; color: #28a745; font-size: 1.2rem; cursor: pointer; }
    .like-btn .fa-thumbs-up { transition: color 0.3s; }
    .like-btn.liked .fa-thumbs-up { color: #ff5c8d; }
</style>
<script>
    document.querySelectorAll('.like-btn').forEach(button => { button.addEventListener('click', function() { this.querySelector('.fa-thumbs-up').classList.toggle('fas'); this.querySelector('.fa-thumbs-up').classList.toggle('far'); this.classList.toggle('liked'); }); });
</script>

                        <!-- Social Media Share Buttons -->
                        <div class="mt-3">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode("https://votre-site.com/event?id=".$produit['id']); ?>" target="_blank" class="social-icon btn btn-outline-primary">
        <i class="fab fa-facebook-f"></i> <!-- Ajout de l'icône de Facebook -->
    </a>
    <a href="https://www.instagram.com/share?url=<?= urlencode("https://votre-site.com/event?id=".$produit['id']); ?>" target="_blank" class="social-icon btn btn-outline-primary social-icon-instagram">
        <i class="fab fa-instagram"></i> <!-- Ajout de l'icône Instagram -->
    </a>
    <a href="https://twitter.com/intent/tweet?url=<?= urlencode("https://votre-site.com/event?id=".$produit['id']); ?>" target="_blank" class="social-icon btn btn-outline-primary social-icon-twitter">
        <i class="fab fa-twitter"></i> <!-- Ajout de l'icône Twitter -->
    </a>
</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

 <!-- Pagination -->
 <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=1&filter=<?= $filter; ?>"><<</a>
            </li>
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1; ?>&filter=<?= $filter; ?>">Précédent</a>
            </li>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1; ?>&filter=<?= $filter; ?>">Suivant</a>
            </li>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $totalPages; ?>&filter=<?= $filter; ?>">>></a>
            </li>
        </ul>
    </nav>
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
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free html  Templates</a></p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
