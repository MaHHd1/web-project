<?php
// Inclure les fichiers nécessaires
require_once 'C:\xampp\htdocs\vegeee\phpmailling\src\PHPMailer.php';
require_once 'C:\xampp\htdocs\vegeee\phpmailling\src\Exception.php';
require_once 'C:\xampp\htdocs\vegeee\phpmailling\src\SMTP.php';


// Fonction pour envoyer l'email
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    
    try {
        // Paramétrage du serveur SMTP (pour Gmail ici)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';                             // Hôte SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'abdallah.lahderi@esprit.tn';              // Votre adresse e-mail
        $mail->Password = 'lixggwivqvqlzhjv';                        // Votre mot de passe ou mot de passe d'application
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('abdallah.lahderi@esprit.tn', 'Votre Nom');
        $mail->addAddress($to);                                     // Adresse du client

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Envoi de l'email
        if ($mail->send()) {
            return true;  // Email envoyé avec succès
        } else {
            return false; // Erreur lors de l'envoi
        }
    } catch (Exception $e) {
        return "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}"; // Erreur
    }
}

// Exemple d'utilisation de la fonction
$to = 'client@example.com';
$subject = 'Confirmation de votre réservation';
$body = '<h1>Merci pour votre réservation !</h1>' . 
        '<p>Votre réservation pour l\'événement <b>[Nom de l\'événement]</b> est confirmée.</p>' .
        '<p>Date : [Date]</p>' .
        '<p>Heure : [Heure]</p>' .
        '<p>Lieu : [Lieu]</p>' .
        '<p>Numéro de réservation : [Numéro]</p>';

// Appel de la fonction sendEmail
if (sendEmail($to, $subject, $body)) {
    echo 'Message envoyé avec succès !';
} else {
    echo 'Échec de l\'envoi de l\'email.';
}
?>
