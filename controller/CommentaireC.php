<?php

require_once  $_SERVER['DOCUMENT_ROOT'] . "/web/config.php";
include_once  $_SERVER['DOCUMENT_ROOT'] . "/web/model/Commentaire.php";

class CommentaireC {
    public function ajouterCommentaire($contenu, $date_creation_cm, $id_question) {
        $db = Config::getConnexion();
        $sql = "INSERT INTO commentaire (contenu, date_creation_cm, id_question) VALUES (:contenu, :date_creation_cm, :id_question)";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $contenu,
                'date_creation_cm' => $date_creation_cm,
                'id_question' => $id_question
            ]);
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function getCommentaireById($id) {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM commentaire WHERE id_commentaire = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
    
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
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteCommentaire($id) {
        $db = Config::getConnexion();
        $sql = "DELETE FROM commentaire WHERE id_commentaire = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return true;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }

    public function getCommentaires() {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM commentaire";

        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
            return false;
        }
    }
}
?>
