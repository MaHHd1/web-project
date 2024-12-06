<?php

class Question {
    private $conn;
    private $table_name = "question";

    private $id_question;
    private $titre;
    private $description;
    private $date_creation;

    public function __construct() {
        $this->conn = Config::getConnexion();
    }

    // Getters
    public function getIdQuestion() {
        return $this->id_question;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    // Setters
    public function setIdQuestion($id_question) {
        $this->id_question = $id_question;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDateCreation($date_creation) {
        $this->date_creation = $date_creation;
    }

    // Read method
    public function read() {
        $query = "SELECT id_question, titre, description, date_creation FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create method
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET titre=:titre, description=:description, date_creation=:date_creation";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date_creation = htmlspecialchars(strip_tags($this->date_creation));

        // Bind parameters
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":date_creation", $this->date_creation);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
