<?php
require_once '../../Controller/ProduitsController.php';

$Pc = new ProduitsController();

// Configuration de la pagination
$limit = 6; // Nombre d'événements par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
$start = ($page - 1) * $limit; // Début des résultats à afficher

// Récupération des événements, en fonction de la recherche ou de la pagination
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchTerm = htmlspecialchars(trim($_GET['search']));
    // Recherche des produits par nom
    $tabP = $Pc->searchProduitsByName($searchTerm, $start, $limit);
    // Total des produits correspondant
    $totalProduits = count($Pc->searchProduitsByName($searchTerm, 0, 0)); 
} else {
    // Récupération paginée des produits
    $tabP = $Pc->listProduitPaginated($start, $limit); 
    // Total des produits sans filtre
    $totalProduits = count($Pc->listProduit()); 
}

$totalPages = ceil($totalProduits / $limit); // Calcul du nombre total de pages
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop de Abdallah</title>
    <!-- Bootstrap CSS -->
     <!-- Font Awesome (pour l'icône de recherche) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Navbar Styles */
        .navbar {
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
            font-size: 18px;
            margin-right: 10px;
        }
        .social_icon a:hover {
            color: #28a745;
        }
        /* Product Section Styles */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .product-details {
            padding: 15px;
            text-align: center;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="../back/index.php">Back Office</a></li>
                    <li class="nav-item"><a class="nav-link" href="vagetables.html">Vagetables</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                </ul>
                <!-- Formulaire de recherche -->
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
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <h1 class="text-center mb-4">Nos Événements</h1>
    <p class="text-center text-muted mb-5">Explorez nos événements passionnants se déroulant près de chez vous.</p>
    <div class="row g-4">
        <?php foreach ($tabP as $produit): ?>
            <div class="col-md-4">
                <div class="product-card">
                    <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>" class="w-100">
                    <div class="product-details">
                        <h5 class="mb-2"><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p class="mb-1 text-muted">Lieu: <?= htmlspecialchars($produit['lieu']); ?></p>
                        <p class="mb-1 text-muted">Date Début: <?= htmlspecialchars($produit['date']); ?></p>
                        <p class="mb-1 text-muted">Date Fin: <?= htmlspecialchars($produit['datef']); ?></p>
                        <p class="text-success fw-bold mb-3">Prix: $<?= htmlspecialchars($produit['pass']); ?></p>
                        <a href="../back/reserver.php?id=<?= $produit['id'] ?>" class="btn btn-primary">Réserver Maintenant</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-primary me-2">Précédent</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-primary">Suivant</a>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<div class="footer_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <h3>Liens Utiles</h3>
                <ul>
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="about.html">À propos</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="domain.html">Domaine</a></li>
                    <li><a href="testimonial">Témoignages</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-6">
                <h3>Adresse</h3>
                <ul>
                    <li><i class="fa fa-map-marker"></i> Some Address, City</li>
                    <li><i class="fa fa-phone"></i> (+71) 1234567890</li>
                    <li><i class="fa fa-envelope"></i> demo@gmail.com</li>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-6">
                <h3>Nous Trouver</h3>
                <p>Suivez-nous sur nos réseaux sociaux</p>
                <div class="social_icon">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
