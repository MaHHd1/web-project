<?php
require_once 'C:\xampp\htdocs\vegeee\controller\ProduitsController.php';
require_once 'C:\xampp\htdocs\vegeee\controller\RController.php'; // Contrôleur pour les réservations

// Vérifier si l'ID du produit est passé dans l'URL
if (isset($_GET['idP'])) {
    $idP = intval($_GET['idP']);
    $Pc = new ProduitsController();
    $produit = $Pc->getProduitById($idP);
    

    if (!$produit) {
        echo "Produit introuvable.";
        exit;
    }

    // Charger les réservations associées au produit
    $Rc = new ReservationController();
    $reservations = $Pc->getReservationsByEvent($idP);
} else {
    echo "ID du produit manquant.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
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

        .product-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .product-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-item {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-item span {
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
        }

        .btn-back {
            display: block;
            margin: 20px auto 0;
            text-align: center;
            background: #228B22;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #1e7a1e;
        }

        .reservations-section {
            margin-top: 40px;
        }

        .reservations-section h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>


<div class="container">
    <h2 class="text-center">Détails du Produit</h2>
    <div class="product-details">
        <div class="product-image">
            <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?= htmlspecialchars($produit['nom']); ?>">
        </div>
        <div class="product-info">
            <div class="info-item">
                <strong>Nom:</strong>
                <span><?= htmlspecialchars($produit['nom']); ?></span>
            </div>
            <div class="info-item">
                <strong>Description:</strong>
                <span><?= htmlspecialchars($produit['description']); ?></span>
            </div>
            <div class="info-item">
                <strong>Lieu:</strong>
                <span><?= htmlspecialchars($produit['lieu']); ?></span>
            </div>
            <div class="info-item">
                <strong>Date Debut:</strong>
                <span><?= htmlspecialchars($produit['date']); ?></span>
            </div>
            <div class="info-item">
                <strong>Date Fin:</strong>
                <span><?= htmlspecialchars($produit['datef']); ?></span>
            </div>
            <div class="info-item">
                <strong>Prix:</strong>
                <span>$<?= htmlspecialchars($produit['pass']); ?></span>
            </div>
        </div>
    </div>

   <?php if (!empty($reservations)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Numéro</th>
                <th>Email</th>
                <th>Quantité</th>
                <th>Date de réservation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['id']); ?></td>
                    <td><?= htmlspecialchars($reservation['nom_p']); ?></td>
                    <td><?= htmlspecialchars($reservation['numero']); ?></td>
                    <td><?= htmlspecialchars($reservation['mail']); ?></td>
                    <td><?= htmlspecialchars($reservation['quantite']); ?></td>
                    <td><?= htmlspecialchars($reservation['date_reservation']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune réservation trouvée pour cet événement.</p>
<?php endif; ?>


</body>
</html>
