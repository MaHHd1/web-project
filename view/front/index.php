<?php
require_once '../../Controller/ProduitsController.php';
$Pc = new ProduitsController();
$tabP = $Pc->listProduit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop de abdallah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Navbar Styles */
        .navbar {
            background-color: #28a745; /* Vert */
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
            background-color: #000; /* Noir */
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
                <form class="form-inline my-2 my-lg-0">
                    <div class="search_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                </form>
            </div>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <h1 class="text-center mb-4">Our Events</h1>
    <p class="text-center text-muted mb-5">Explore our exciting events and activities happening near you.</p>
    <div class="row g-4">
        <?php foreach ($tabP as $produit): ?>
            <div class="col-md-4">
                <div class="product-card">
                    <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>" class="w-100">
                    <div class="product-details">
                        <h5 class="mb-2"><?= htmlspecialchars($produit['nom']); ?></h5>
                        <p class="mb-1 text-muted">Location: <?= htmlspecialchars($produit['lieu']); ?></p>
                        <p class="mb-1 text-muted">Date: <?= htmlspecialchars($produit['date']); ?></p>
                        <p class="text-success fw-bold mb-3">Price: $<?= htmlspecialchars($produit['pass']); ?></p>
                     <!--   <a href="../back/reserver.php" class="btn btn-primary">Reserve Now</a>-->
                        <a href="../back/reserver.php?id=<?php echo $produit['id']; ?>" class="btn btn-primary">Reserve Now</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer -->
<div class="footer_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <h3>Useful links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="domain.html">Domain</a></li>
                    <li><a href="testimonial">Testimonial</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-6">
                <h3>Address</h3>
                <ul>
                    <li><i class="fa fa-map-marker"></i> Some Address, City</li>
                    <li><i class="fa fa-phone"></i> (+71) 1234567890</li>
                    <li><i class="fa fa-envelope"></i> demo@gmail.com</li>
                </ul>
            </div>
            <div class="col-lg-4 col-sm-6">
                <h3>Find Us</h3>
                <p>Follow us on our social media platforms</p>
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
