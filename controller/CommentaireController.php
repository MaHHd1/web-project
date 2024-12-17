<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Commentaire.php');

class CommentaireController
{
    // Lister tous les commentaires
    public function listCommentaires()
    {
        $sql = "SELECT * FROM commentaires";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Supprimer un commentaire
    public function deleteCommentaire($id)
    {
        // Vérification si le commentaire existe
        $checkSql = "SELECT COUNT(*) FROM commentaires WHERE id_comment  = :id";
        $db = config::getConnexion();
        $checkReq = $db->prepare($checkSql);
        $checkReq->bindValue(':id', $id, PDO::PARAM_INT);
        $checkReq->execute();
    
        // Si aucun commentaire n'est trouvé, on retourne false
        if ($checkReq->fetchColumn() == 0) {
            return false; // Le commentaire n'existe pas
        }
    
        // Suppression du commentaire
        $sql = "DELETE FROM commentaires WHERE id_comment  = :id";
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
    
        try {
            return $req->execute(); // Retourne true si la suppression a réussi, false sinon
        } catch (Exception $e) {
            error_log('Erreur lors de la suppression du commentaire : ' . $e->getMessage());
            return false;
        }
    }
    
    // Ajouter un commentaire
    public function addCommentaire($commentaire)
    {
        $sql = "INSERT INTO commentaires (id_user, date, note, id_articles)
                VALUES (:id_user, :date, :note, :id_articles)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_user' => $commentaire->getIdUser(),
                'date' => $commentaire->getDate()->format('Y-m-d H:i:s'),
                'note' => $commentaire->getNote(),
                'id_articles' => $commentaire->getIdArticles()  // Liaison avec l'article
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    // Mettre à jour un commentaire
    public function updateCommentaire($commentaire, $id_comment)
    {
        $sql = "UPDATE commentaires SET 
                note = :note
            WHERE id_comment = :id_comment";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_comment' => $id_comment,
                'note' => $commentaire->getNote()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


public function addCommentairee(Commentaire $commentaire)
    {
        // Connexion à la base de données
        $db = config::getConnexion();
        
        // Requête SQL pour insérer le commentaire
        $sql = "INSERT INTO commentaires ( id_articles, comment_text)
                VALUES (:id_articles, :comment_text)";

        try {
            // Préparer la requête
            $query = $db->prepare($sql);

            // Exécuter la requête avec les paramètres de l'objet Commentaire
            $query->execute([
                'id_articles' => $commentaire->getIdArticle(),
                'comment_text' => $commentaire->getCommentText()
            ]);
            return true;  // Retourne true si l'ajout est réussi
        } catch (Exception $e) {
            // Si une erreur se produit, afficher l'erreur
            echo 'Error: ' . $e->getMessage();
            return false;  // Retourne false si une erreur se produit
        }
    }
}
?>
