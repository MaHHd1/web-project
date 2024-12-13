<?php
require_once '../config/DbConfig.php';

class Reponse {
    private $id;
    private $reclamationId;
    private $utilisateurId;
    private $reponse_text;
    private $pdo;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->pdo = $dbConfig->getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getReclamationId() {
        return $this->reclamationId;
    }

    public function setReclamationId($reclamationId) {
        $this->reclamationId = $reclamationId;
    }

    public function getUtilisateurId() {
        return $this->utilisateurId;
    }

    public function setUtilisateurId($utilisateurId) {
        $this->utilisateurId = $utilisateurId;
    }

    public function getreponseText() {
        return $this->reponse_text;
    }

    public function setreponseText($reponse_text) {
        $this->reponse_text = $reponse_text;
    }

    public function create() {
        $stmt = $this->pdo->prepare("INSERT INTO reponses (reclamationId, utilisateurId, reponse_text) VALUES (?, ?, ?)");
        $stmt->execute([$this->reclamationId, $this->utilisateurId, $this->reponse_text]);
        $this->id = $this->pdo->lastInsertId(); 
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reponses WHERE id = ?");
        $stmt->execute([$id]);
        $reponse = $stmt->fetch();
        if ($reponse) {
            $this->id = $reponse['id'];
            $this->reclamationId = $reponse['reclamationId'];
            $this->utilisateurId = $reponse['utilisateurId'];
            $this->reponse_text = $reponse['reponse_text'];
            return $this;
        }
        return null;
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE reponses SET reclamationId = ?, utilisateurId = ?, reponse_text = ? WHERE id = ?");
        return $stmt->execute([$this->reclamationId, $this->utilisateurId, $this->reponse_text, $this->id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reponses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getByReclamationId($reclamationId) {
        $stmt = $this->pdo->prepare("SELECT * FROM reponses WHERE reclamationId = ?");
        $stmt->execute([$reclamationId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'reponse');
    }
    
}