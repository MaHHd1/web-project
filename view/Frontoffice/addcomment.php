<?php
include '../../controller/CommentaireController.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier que la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées via le formulaire
    $article_id = $_POST['article_id'];  // ID de l'article
    $comment_text = $_POST['comment'];   // Contenu du commentaire

    // Vérifier si l'utilisateur est connecté (par exemple, récupérer l'ID de l'utilisateur)
    $user_id = 1;  // Remplacez par l'ID de l'utilisateur connecté, par exemple via session

    // Créer une instance de la classe Commentaire
    $commentaire = new Commentaire(null, $user_id, $article_id, $comment_text, new DateTime());

    // Créer une instance du contrôleur CommentaireController
    $commentairesController = new CommentaireController();

    // Appeler la méthode pour ajouter le commentaire
    $result = $commentairesController->addCommentairee($commentaire);

    // Vérifier si l'ajout a réussi
    if ($result) {
        echo "<script>
        if (Notification.permission === 'granted') {
            new Notification('Succès', { body: 'Votre commentaire a été ajouté avec succès.' });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    new Notification('Succès', { body: 'Votre commentaire a été ajouté avec succès.' });
                }
            });
        }
    </script>";




        // Envoi d'un email à l'administrateur
        $adminEmail = 'hammammi.nour@esprit.tn'; // Adresse email de l'administrateur
      //  $userEmail = 'user@example.com'; // Adresse email de l'utilisateur (ajoutez-le si nécessaire)

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nourhammemi893@gmail.com'; // Remplacez par votre email
            $mail->Password = 'hrcicvllvftjemil'; // Remplacez par votre mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Configuration de l'email
            $mail->setFrom('nourhammemi893@gmail.com', 'Farment Support'); // Adresse de l'expéditeur
            $mail->addAddress($adminEmail); // Destinataire (admin)

            // Ajouter l'utilisateur en copie, si nécessaire
            // $mail->addCC($userEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Nouveau commentaire ajouté';
            $mail->Body = '
                <p>Bonjour Administrateur,</p>
                <p>Un nouveau commentaire a été ajouté à l\'article ID : ' . htmlspecialchars($article_id) . '.</p>
                <p><strong>Commentaire :</strong> ' . nl2br(htmlspecialchars($comment_text)) . '</p>
                <p><strong>ID Utilisateur :</strong> ' . htmlspecialchars($user_id) . '</p>
                <br>
                <p>Cordialement,</p>
                <p>L\'équipe de FarmFresh</p>
            ';

            // Envoi de l'email
            $mail->send();

        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        }

        // Redirection vers la liste des articles
        header("Location: ArticlesList.php?notification=success");
        exit();
    } else {
        // Si l'ajout échoue, afficher une erreur
        echo 'Erreur lors de l\'ajout du commentaire.';
    }
}
