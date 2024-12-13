<?php
require_once '../../Controller/ProduitsController.php';
require_once '../../Controller/RController.php';

// Initialisation des contrôleurs
$reservationController = new ReservationController();
$produitsController = new ProduitsController();

// Initialisation des messages
$message = '';
$error = '';

$nom_p = $_GET['nom_p'];
$numero = intval($_GET['numero']);
$mail = $_GET['mail'];
$quantite = intval($_GET['quantity']) ?? 0;
$reservationId =intval($_GET['id']);

// Traitement des actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['validate'])) {
        $reservation = new Reservation($reservationId, $nom_p, $numero, $mail, $quantite);
        $controller = new ReservationController();
        $controller->addReservation($reservation);
        exit;
    }
    if (isset($_POST['update'])) {
        // Ajoutez ici votre logique de traitement (validation, mise à jour, etc.)
    
        // Redirige vers la page précédente
        $id = $_GET['id'];
        header("Location: reserver.php?id=$id");
        exit();
    }
    
    

    if (isset($_POST['cancel'])) {
        echo "<script>window.history.back();</script>";
        exit;
    }
    
}

/*if (isset($_POST['update'])) {
    // Redirection vers la page réserver
    header('Location: reserver.php');
    exit();
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    exit();
}*/


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
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
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
        .btn-secondary {
            width: 100%;
            padding: 12px;
            background: #FFD300;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            text-transform: uppercase;
            transition: background 0.3s ease;
            cursor: pointer;
        }
        .btn-secondary:hover {
            background: #F8DE7E;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            background: #d9534f;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            text-transform: uppercase;
        }
        .btn-danger:hover {
            background: #c9302c;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
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
                     <a class="nav-link" href="/vegeee/view/front/index.php">Home</a>


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
<div class="container">
    <h2>Confirmation de Réservation</h2>

    <!-- Messages de succès ou d'erreur -->
    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    
    <form method="POST" action="">
    <!-- Champ pour le nom -->
    <div class="form-group">
        <label for="nom_p">Nom: </label>
        <label for="nom_p"><?= htmlspecialchars($nom_p); ?></label>
    </div>

    <!-- Champ pour le numéro de téléphone -->
    <div class="form-group">
        <label for="numero">Numéro de téléphone: </label>
        <label for="numero"><?= htmlspecialchars($numero); ?></label>
    </div>

    <!-- Champ pour l'adresse email -->
    <div class="form-group">
        <label for="mail">Email: </label>
        <label for="mail"><?= htmlspecialchars($mail); ?></label>
    </div>

    <!-- Champ pour la quantité -->
    <div class="form-group">
        <label for="quantite">Quantité: </label>
        <label for="quantite"><?= htmlspecialchars($quantite); ?></label>
    </div>

    <!-- Boutons d'action -->
    <button type="submit" name="validate" class="btn btn-primary">Validate</button>
    <button type="button" onclick="imprimer()" class="btn btn-secondary">Imprimer cette confirmation</button>

</form>

    
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
      <script>
    function imprimer() {
        window.print();
    }
</script>

</body>
</html>
