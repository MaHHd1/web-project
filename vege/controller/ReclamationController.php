<?php
require_once '../config/DbConfig.php';
require_once '../model/Reclamation.php';

class ReclamationController {
    private $reclamationModel;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->reclamationModel = new Reclamation($dbConfig->getConnection());
    }

    public function create( $utilisateurId, $produitId, $note,$email,$content) {
        $this->reclamationModel->setUtilisateurId($utilisateurId);
        $this->reclamationModel->setProduitId($produitId);
        $this->reclamationModel->setContent($content);
        $this->reclamationModel->setNote($note);
        $this->reclamationModel->setemail($email);
        $this->reclamationModel->create();
    }

    public function read($id) {
        return $this->reclamationModel->read($id);
    }

    public function update($id, $utilisateurId, $produitId, $note, $email, $content) {
        $this->reclamationModel->setId($id);
        $this->reclamationModel->setUtilisateurId($utilisateurId);
        $this->reclamationModel->setContent($content);
        $this->reclamationModel->setProduitId($produitId);
        $this->reclamationModel->setNote($note);
        $this->reclamationModel->setemail($email);
        return $this->reclamationModel->update();
    }

    public function delete($id) {
        return $this->reclamationModel->delete($id);
    }

    public function getAll() {
        return $this->reclamationModel->getAll();
    }
    public function getById($id) {
        return $this->reclamationModel->getById($id);
    }
}
?>