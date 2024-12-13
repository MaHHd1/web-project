<?php
require_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../model/Commentaire.php";
include_once __DIR__ . "/send_email.php"; // Include the email function

class CommentaireC {
    // Method to add a comment and send email notification
    public function ajouterCommentaire($contenu, $date_creation_cm, $id_question, $recipientEmail = null) {
        $db = Config::getConnexion();
        $sql = "INSERT INTO commentaire (contenu, date_creation_cm, id_question) VALUES (:contenu, :date_creation_cm, :id_question)";

        try {
            // Insert the comment into the database
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $contenu,
                'date_creation_cm' => $date_creation_cm,
                'id_question' => $id_question
            ]);

            // Send email notification after the comment is added
            if ($recipientEmail) { // Check if the email is provided
                $subject = "New Comment Added";
                $messageBody = "A new comment has been added to your question: <br><br>" . htmlspecialchars($contenu);
                $emailSent = sendNotificationEmail($recipientEmail, $subject, $messageBody);

                if (!$emailSent) {
                    error_log("Email could not be sent to $recipientEmail.");
                }
            }

            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    // Method to update a comment
    public function modifierCommentaire($id, $contenu, $date_creation_cm, $id_question) {
        $db = Config::getConnexion();
        $sql = "UPDATE commentaire SET contenu = :contenu, date_creation_cm = :date_creation_cm, id_question = :id_question WHERE id_commentaire = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $contenu,
                'date_creation_cm' => $date_creation_cm,
                'id_question' => $id_question,
                'id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    // Method to delete a comment
    public function deleteCommentaire($id) {
        $db = Config::getConnexion();
        $sql = "DELETE FROM commentaire WHERE id_commentaire = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    // Method to fetch all comments
    public function getCommentaires() {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM commentaire";

        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    // Method to fetch comments by question ID
    public function getCommentairesByQuestion($id_question) {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM commentaire WHERE id_question = :id_question";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id_question' => $id_question]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    // Method to fetch a single comment by its ID
    public function getCommentaireById($id) {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM commentaire WHERE id_commentaire = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }
}
?>
