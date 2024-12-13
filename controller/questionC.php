<?php

require_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../model/Question.php";

class QuestionC {
    public function ajouterQuestion($titre, $description, $date_creation) {
        $db = Config::getConnexion();
        $sql = "INSERT INTO question (titre, description, date_creation) VALUES (:titre, :description, :date_creation)";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'titre' => $titre,
                'description' => $description,
                'date_creation' => $date_creation
            ]);
            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function getQuestions() {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM question";

        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function getQuestionById($id) {
        $db = Config::getConnexion();
        $sql = "SELECT * FROM question WHERE id_question = :id_question";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id_question' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function modifierQuestion($id, $titre, $description, $date_creation) {
        $db = Config::getConnexion();
        $sql = "UPDATE question SET titre = :titre, description = :description, date_creation = :date_creation WHERE id_question = :id_question";

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_question' => $id,
                'titre' => $titre,
                'description' => $description,
                'date_creation' => $date_creation
            ]);
            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function deleteQuestion($id) {
        $db = Config::getConnexion();
        $sql = "DELETE FROM question WHERE id_question = :id_question";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id_question' => $id]);
            return true;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function getQuestion($offset = 0, $limit = 10) {
        $db = Config::getConnexion();
        try {
            $stmt = $db->prepare("SELECT * FROM question LIMIT :offset, :limit");
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            error_log('Error in ' . __FUNCTION__ . ': ' . $e->getMessage());
            return false;
        }
    }
}
?>
