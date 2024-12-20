<?php
require_once '../../Controller/ProduitsController.php';
require_once '../../Controller/RController.php';
require_once '../../Controller/LoginController.php';
session_start();

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
        // Préparer les données pour l'e-mail
        $subject = "Confirmation de votre réservation";
        $message = "Bonjour $nom_p,\n\nMerci pour votre réservation de $quantite places pour l'événement " . htmlspecialchars($produit['nom']) . ".\n\nCordialement,\nL'équipe.";

        // Inclure le fichier d'envoi d'e-mail
        require '../../i.php';
 // Assurez-vous que le chemin est correct

        // Passer les données à i.php et appeler la fonction d'envoi
        $_POST['email'] = $mail; // Adresse e-mail du client
        $_POST['subject'] = $subject;
        $_POST['message'] = $message;

        // Appeler la fonction d'envoi d'e-mail
        sendEmail($_POST['email'], $_POST['subject'], $_POST['message']);
        
        // Rediriger vers confirmation.php avec les paramètres nécessaires
        header("Location: confirmation.php?id=$id&nom_p=$nom_p&numero=$numero&mail=$mail&quantity=$quantite");
        exit();
    }

   /* if (empty($error)) {
        // Rediriger vers confirmation.php avec les paramètres nécessaires
        header("Location: confirmation.php?id=$id&nom_p=$nom_p&numero=$numero&mail=$mail&quantity=$quantite");
        
      // Préparer les données pour l'e-mail
      $subject = "Confirmation de votre réservation";
      $message = "Bonjour $nom_p,\n\nMerci pour votre réservation de $quantite places pour l'événement " . htmlspecialchars($produit['nom']) . ".\n\nCordialement,\nL'équipe.";

      // Inclure le fichier d'envoi d'e-mail
      include 'i.php'; // Assurez-vous que le chemin est correct

      // Passer les données à i.php et appeler la fonction d'envoi
      $_POST['email'] = $mail; // Adresse e-mail du client
      $_POST['subject'] = $subject;
      $_POST['message'] = $message;
      
      // Appeler la fonction d'envoi d'e-mail
      sendEmail($_POST['email'], $_POST['subject'], $_POST['message']);
      
      exit();
    }*/
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
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
    <link rel="stylesheet" type="text/css" href="css/style1.css">
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
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: #333;
            font-family: Arial, sans-serif;
        }

        /* Style de base pour la checkbox */
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            border: 1px solid #aaa;
            border-radius: 4px;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        /* Couleur lorsqu'elle est cochée */
        input[type="checkbox"]:checked {
            background-color: #007bff;
            border-color: #0056b3;
        }

        /* Texte associé */
        label {
            cursor: pointer;
        }

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
                        <a class="nav-link" href="/integration/View/front_office/html/index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../back/index.php">Back Office</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vagetables.html">Vagetables</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
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
        <div class="checkbox-container">
            <input type="checkbox" id="emailCheckbox" />
            <label for="emailCheckbox">Utiliser cet email pour vous connecter</label>
        </div>

        <!-- Affichage des erreurs -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <button id="fillOutBtn">Fill Out</button>
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


<!-- End Footer -->
<script>
    document.getElementById('reservationForm').addEventListener('submit', function(event) {
        // Empêcher l'envoi du formulaire par défaut
        event.preventDefault();

        // Récupérer les valeurs des champs
        let nom_p = document.getElementById('nom_p').value.trim();
        let numero = document.getElementById('numero').value.trim();
        let mail = document.getElementById('mail').value.trim();
        let quantite = document.getElementById('quantite').value.trim();

        // Variable pour stocker les messages d'erreur
        let errorMessages = [];

        // Validation des champs
        if (!nom_p) {
            errorMessages.push("Le nom est obligatoire.");
        }
        if (!numero) {
            errorMessages.push("Le numéro de téléphone est obligatoire.");
        }
        if (!mail) {
            errorMessages.push("L'email est obligatoire.");
        } else if (!validateEmail(mail)) {
            errorMessages.push("L'email n'est pas valide.");
        }
        if (!quantite || quantite <= 0) {
            errorMessages.push("La quantité doit être un nombre positif.");
        }

        // Afficher les erreurs ou soumettre le formulaire
        if (errorMessages.length > 0) {
            alert(errorMessages.join("\n")); // Afficher les erreurs
        } else {
            this.submit(); // Soumettre le formulaire si tout est valide
        }
    });

    // Fonction de validation d'email
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
</script>

    <script>
        document.getElementById('fillOutBtn').addEventListener('click', function() {
        let name = "<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>";
        let email = "<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>";
        let phone = "<?php echo isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : ''; ?>";

        // Fill out the form with session data or leave it empty if not set
        document.getElementById('nom_p').value = name || "Nom non disponible";
        document.getElementById('mail').value = email || "Email non disponible";
        document.getElementById('numero').value = phone || "Numéro non disponible";
    });
</script>




</body>
</html>