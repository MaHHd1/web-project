<?php
require_once '../config/DbConfig.php';

class Reclamation {
    private $id;
    private $utilisateurId;
    private $produitId;
    private $content; 
    private $note;
    private $email;
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

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) { 
        $this->content = $content;
    }

    public function getUtilisateurId() {
        return $this->utilisateurId;
    }

    public function setUtilisateurId($utilisateurId) {
        $this->utilisateurId = $utilisateurId;
    }

    public function getProduitId() {
        return $this->produitId;
    }

    public function setProduitId($produitId) {
        $this->produitId = $produitId;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }
    public function getemail() {
        return $this->id;
    }

    public function setemail($email) {
        $this->email = $email;
    }


    public function create() {
        $stmt = $this->pdo->prepare("INSERT INTO reclamations (utilisateurId, produitId, email,note, content) VALUES (?,?,?,?,?)"); 
        $stmt->execute([$this->utilisateurId, $this->produitId, $this->note,$this->email, $this->content]);
        $this->id = $this->pdo->lastInsertId();
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reclamations WHERE id = ?");
        $stmt->execute([$id]);
        $reclamation = $stmt->fetch();
        if ($reclamation) {
            $this->id = $reclamation['id'];
            $this->utilisateurId = $reclamation['utilisateurId'];
            $this->produitId = $reclamation['produitId'];
            $this->content = $reclamation['content']; 
            $this->note = $reclamation['note'];
            $this->email = $reclamation['email'];

            return $this;
        }
        return null;
    }

    public function update() {
        $stmt = $this->pdo->prepare("UPDATE reclamations SET utilisateurId = ?, produitId = ?, note = ?, content = ? WHERE id = ?, email = ?"); 
        return $stmt->execute([$this->utilisateurId, $this->produitId, $this->note, $this->content, $this->id,$this->email]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM reclamations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM reclamations");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Reclamation');
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reclamations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject('Reclamation');
    }

}
?>