<?php
require_once 'C:\xampp\htdocs\vegeee\fpdf\fpdf.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Récupérer les données passées par GET
$nom_p = $_GET['nom_p'] ?? 'Inconnu';
$numero = $_GET['numero'] ?? 'Inconnu';
$mail = $_GET['mail'] ?? 'Inconnu';
$quantite = $_GET['quantity'] ?? 0;

// Configuration de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Pour charger des ressources distantes si nécessaire
$dompdf = new Dompdf($options);

// Contenu HTML pour le PDF
$html = "
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmation de Réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        h1 {
            color: #228B22;
            text-align: center;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Confirmation de Réservation</h1>
    <div class='details'>
        <p><strong>Nom :</strong> $nom_p</p>
        <p><strong>Numéro de téléphone :</strong> $numero</p>
        <p><strong>Email :</strong> $mail</p>
        <p><strong>Quantité :</strong> $quantite</p>
    </div>
    <p>Merci pour votre réservation. Nous vous contacterons sous peu pour finaliser les détails.</p>
</body>
</html>
";

// Charger le contenu HTML dans Dompdf
$dompdf->loadHtml($html);

// Configurer la taille du papier et l'orientation
$dompdf->setPaper('A4', 'portrait');

// Rendre le PDF
$dompdf->render();

// Envoyer le fichier PDF au navigateur et ouvrir directement l'outil d'impression
$dompdf->stream('confirmation_reservation.pdf', ['Attachment' => false]);

// L'option 'Attachment' => false force l'affichage dans le navigateur
exit;
?>