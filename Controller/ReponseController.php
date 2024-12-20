<?php
require_once '../config/DbConfig.php';
require_once '../model/Reponse.php';

class ReponseController {
    private $reponseModel;

    public function __construct() {
        $dbConfig = new DbConfig();
        $this->reponseModel = new reponse($dbConfig->getConnection());
    }

    public function create($reclamationId, $utilisateurId, $commentaire) {
        $this->reponseModel->setReclamationId($reclamationId);
        $this->reponseModel->setUtilisateurId($utilisateurId);
        $this->reponseModel->setreponseText($commentaire);
        $this->reponseModel->create();
    }

    public function read($id) {
        return $this->reponseModel->read($id);
    }

    public function update($id, $reclamationId, $utilisateurId, $commentaire) {
        $this->reponseModel->setId($id);
        $this->reponseModel->setReclamationId($reclamationId);
        $this->reponseModel->setUtilisateurId($utilisateurId);
        $this->reponseModel->setreponseText($commentaire);
        return $this->reponseModel->update();
    }

    public function delete($id) {
        return $this->reponseModel->delete($id);
    }

    public function getByReclamationId($reclamationId) {
        return $this->reponseModel->getByReclamationId($reclamationId);
    }
}
?>