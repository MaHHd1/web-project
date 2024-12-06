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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmation de Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
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
</form>

    
</div>
</body>
</html>
