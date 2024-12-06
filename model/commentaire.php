<?php

class Commentaire {
    private $conn;
    private $table_name = "commentaire";

    private $id_commentaire;
    private $contenu;
    private $date_creation_cm;
    private $id_question;

    public function __construct() {
        $this->conn = Config::getConnexion();
    }

    // Getters
    public function getIdCommentaire() {
        return $this->id_commentaire;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDateCreationCm() {
        return $this->date_creation_cm;
    }

    public function getIdQuestion() {
        return $this->id_question;
    }

    // Setters
    public function setIdCommentaire($id_commentaire) {
        $this->id_commentaire = $id_commentaire;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function setDateCreationCm($date_creation_cm) {
        $this->date_creation_cm = $date_creation_cm;
    }

    public function setIdQuestion($id_question) {
        $this->id_question = $id_question;
    }

    // Read method
    public function read() {
        $query = "SELECT id_commentaire, contenu, date_creation_cm, id_question FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET contenu=:contenu, date_creation_cm=:date_creation_cm, id_question=:id_question";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->contenu = htmlspecialchars(strip_tags($this->contenu));
        $this->date_creation_cm = htmlspecialchars(strip_tags($this->date_creation_cm));
        $this->id_question = htmlspecialchars(strip_tags($this->id_question));

        // Bind parameters
        $stmt->bindParam(":contenu", $this->contenu);
        $stmt->bindParam(":date_creation_cm", $this->date_creation_cm);
        $stmt->bindParam(":id_question", $this->id_question);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
