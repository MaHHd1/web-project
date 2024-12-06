<?php
require_once '../../Controller/ProduitsController.php';
require_once '../../Controller/RController.php';

// Vérifier si l'ID de l'événement est passé dans l'URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $Pc = new ProduitsController();
    $produit = $Pc->getProduitById($id);

    if (!$produit) {
        echo "Événement introuvable.";
        exit;
    }
} else {
    echo "ID de l'événement manquant.";
    exit;
}

// Traitement de la réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_p = $_POST['nom_p'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $mail = $_POST['mail'] ?? '';
    $quantite = $_POST['quantite'] ?? '';

    $error = '';

    if (empty($nom_p) || empty($numero) || empty($mail) || empty($quantite)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Ajouter la réservation
        //$reservation = new Reservation($id, $nom_p, $numero, $mail, $quantite);
        //$controller = new ReservationController();
        //$reservationId = $controller->addReservation($reservation);

        // Rediriger vers confirmation.php avec les paramètres nécessaires
        header("Location: confirmation.php?id=$id&nom_p=$nom_p&numero=$numero&mail=$mail&quantity=$quantite");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails de l'Événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
            position: relative;
        }

        h2::after {
            content: '';
            width: 50px;
            height: 4px;
            background: #228B22;
            display: block;
            margin: 10px auto 0;
            border-radius: 2px;
        }

        .event-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .event-image {
            flex: 1;
            min-width: 300px;
            max-width: 400px;
        }

        .event-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .event-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 15px;
            background: #f8f8f8;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-item img {
            width: 40px;
            height: 40px;
        }

        .info-item span {
            font-size: 1.1em;
            font-weight: 600;
            color: #555;
        }

        .form-section {
            margin-top: 30px;
        }

        .form-section h3 {
            text-align: center;
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 5px;
            font-size: 1em;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: #228B22;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1e7a1e;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #228B22;
        }

        .navbar-brand img {
            width: 150px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-size: 1.1em;
            margin-left: 20px;
        }

        .navbar-nav .nav-link:hover {
            color: #f1f1f1 !important;
        }

        /* Footer Styles */
.footer_section {
    background-color: black;
    color: green;
    padding: 40px 0;
}

.footer_section h3 {
    font-size: 1.5em;
    margin-bottom: 15px;
}

.footer_section ul {
    list-style: none;
    padding-left: 0;
}

.footer_section ul li {
    margin: 8px 0;
}

.footer_section ul li a {
    color: black;
    text-decoration: none;
    font-size: 1.1em;
}

.footer_section ul li a:hover {
    color: black;
}
.highlight-section {
    position: relative;
    height: 400px;
    margin: 30px auto;
    padding: 20px;
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background-color: #000; /* Fond noir pour un contraste artistique */
}

.highlight-slider {
    position: absolute;
    top: 0;
    left: 0;
    width: 200%;
    display: flex;
    justify-content: center;  /* Centre horizontalement */
    align-items: center;      /* Centre verticalement */
    animation: slide-horizontal-infinite 15s linear infinite;
}

.highlight-slider img {
    width: 600%; 
    height: 400%;
    object-fit: cover; /* Pour couvrir toute la zone */
    object-position: center; /* Centre l'image */
}


.highlight-text {
    position: relative;
    z-index: 2;
    color: white;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
}

.highlight-text h3 {
    font-size: 2.5em;
    margin-bottom: 15px;
}

.highlight-text p {
    font-size: 1.2em;
    margin: 5px 0;
}

.highlight-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Superposition sombre pour la lisibilité */
    z-index: 1;
}

/* Animation pour le mouvement fluide */
@keyframes slide-horizontal-infinite {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%); /* Déplace le conteneur de la moitié de sa largeur */
    }
}




    </style>
</head>
<body>

<!-- Navbar -->
<div class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="Logo"></a>
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
            </div>
        </nav>
    </div>
</div>
<div class="highlight-section">
    <div class="highlight-slider">
        <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
        <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
    </div>
    <div class="highlight-text">
        <h3><?= htmlspecialchars($produit['nom']); ?></h3>
        <p>Date de début : <span><?= htmlspecialchars($produit['date']); ?></span></p>
        <p>Date de fin : <span><?= htmlspecialchars($produit['datef']); ?></span></p>
    </div>
</div>





<div class="container">
    <h2>Détails de l'Événement</h2>
    <div class="event-details">
        <div class="event-image">
            <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
        </div>
        <div class="event-info">
            <div class="info-item">
                <img src="images/ee.png" alt="Nom">
                <span><?= htmlspecialchars($produit['nom']); ?></span>
            </div>
            <div class="info-item">
                <img src="images/dd.png" alt="Lieu">
                <span><?= htmlspecialchars($produit['lieu']); ?></span>
            </div>
            <div class="info-item">
                <img src="images/bb.png" alt="Date">
                <span><?= htmlspecialchars($produit['date']); ?></span>
            </div>
            <div class="info-item">
                <img src="images/bb.png" alt="Datef">
                <span><?= htmlspecialchars($produit['datef']); ?></span>
            </div>
            <div class="info-item">
                <img src="images/cc.png" alt="Prix">
                <span>$<?= htmlspecialchars($produit['pass']); ?></span>
            </div>
        </div>
    </div>

<!-- Formulaire de réservation -->
<div class="form-section">
    <h3>Réservez Votre Place</h3>

    <!-- Affichage des erreurs -->
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="reservationForm">
        <div class="form-group">
            <label for="nom_p">Nom</label>
            <input type="text" id="nom_p" name="nom_p" class="form-control" placeholder="Votre nom complet">
        </div>
        <div class="form-group">
            <label for="numero">Numéro de téléphone</label>
            <input type="text" id="numero" name="numero" class="form-control" placeholder="Ex : 0612345678">
        </div>
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" id="mail" name="mail" class="form-control" placeholder="Votre adresse email">
        </div>
        <div class="form-group">
            <label for="quantite">Quantité</label>
            <input type="number" id="quantite" name="quantite" class="form-control" placeholder="Nombre de places">
        </div>
        <button type="submit" class="btn-primary">Réserver</button>
    </form>
</div>


</div>
<!-- Footer -->
<div class="footer_section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>About Us</h3>
                <ul>
                    <li><a href="#">Company</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Products</h3>
                <ul>
                    <li><a href="#">Vegetables</a></li>
                    <li><a href="#">Fruits</a></li>
                    <li><a href="#">Grains</a></li>
                    <li><a href="#">Dairy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Contact Us</h3>
                <ul>
                    <li><a href="#">Contact Information</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Support</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- End Footer -->
<script src="reservation.js" defer></script>

</body>
</html>
