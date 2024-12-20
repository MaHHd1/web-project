<?php
include '../config1.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (isset($_POST["sujet"]) && isset($_POST["utilisateur_id"]) && isset($_POST["description"])) {
    $sujet = $_POST["sujet"];
    $utilisateur_id = $_POST["utilisateur_id"];
    $description = $_POST["description"];

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('');
    $mail->addAddress('chahd.troudi@esprit.tn'); 

    $mail->isHTML(true);
    $mail->Subject = 'nouveau reclamation';
    $mail->Body = '
        <p>Bonjour Mr/Mme,</p>
        <p><strong>Sujet de la réclamation :</strong> ' . htmlspecialchars($sujet) . '</p>
        <p><strong>ID Utilisateur :</strong> ' . htmlspecialchars($utilisateur_id) . '</p>
        <p><strong>Description :</strong> ' . nl2br(htmlspecialchars($description)) . '</p>
        <br>
        <p>Cordialement,</p>
        <p>L\'équipe de farmfresh</p>
    ';

    $mail->send();
}
?>
