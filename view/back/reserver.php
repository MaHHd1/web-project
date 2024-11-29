
<?php
require_once  '../../controller/RController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $nom_p = $_POST['nom_p'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $mail = $_POST['mail'] ?? '';
    var_dump($id, $nom_p, $numero, $mail);
    if (!empty($nom_p) && !empty($numero) && !empty($mail)) {
        $reservation = new Reservation($id, $nom_p, $numero, $mail);
        $controller = new ReservationController();
        $controller->addReservation($reservation);
        header("Location: lister.php"); // Redirection après succès
        exit();
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Shop</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .header_section {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
        }
        .header_section .navbar-brand img {
            max-height: 50px;
        }
        .ajout-produit {
            margin-top: 50px;
        }
        .ajout-produit .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .ajout-produit .card-header {
            background-color: #007bff;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .footer_section {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
        }
        .footer_section a {
            color: #007bff;
        }
        .footer_section a:hover {
            text-decoration: none;
            color: #0056b3;
        }
        .social_icon a {
            color: white;
            font-size: 20px;
            margin-right: 10px;
        }
        .social_icon a:hover {
            color: #007bff;
        }
    </style>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link text-white" href="index.html">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="shop.html">Boutique</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="../back/index.php">Back Office</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="vagetables.html">Légumes</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="blog.html">Blog</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Ajouter Produit Section -->
    <section class="ajout-produit py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">Réservation</div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nom_p">Nom complet :</label>
                                    <input type="text" id="nom_p" name="nom_p" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="numero">Numéro de téléphone :</label>
                                    <input type="tel" id="numero" name="numero" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="mail">Adresse email :</label>
                                    <input type="email" id="mail" name="mail" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Réserver</button>
                                <button type="reset" class="btn btn-secondary btn-block">Réinitialiser</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <h3>Liens utiles</h3>
                    <ul>
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="about.html">À propos</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="domain.html">Domain</a></li>
                        <li><a href="testimonial.html">Témoignages</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3>Adresse</h3>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> Exemple Adresse, Ville</li>
                        <li><i class="fa fa-phone"></i> (+71) 1234567890</li>
                        <li><i class="fa fa-envelope"></i> demo@gmail.com</li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h3>Nous suivre</h3>
                    <ul class="social_icon">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; 2024 Tous droits réservés. Design personnalisé par ChatGPT.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
