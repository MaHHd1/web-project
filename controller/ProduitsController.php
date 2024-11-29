<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../Model/Produits.php';
class ProduitsController
{

    public function listProduit()
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM produitv");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getProduitById($id)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM PRODUITV WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function addProduit($produit)
    {
        $sql = "INSERT INTO PRODUITV (nom, description, pass, lieu, date, image) VALUES (:nom, :description, :pass, :lieu, :date, :image)";
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                ':nom' => $produit->getNom(),
                ':description' => $produit->getDescription(),
                ':pass' => $produit->getPass(),
                ':lieu' => $produit->getLieu(),
                ':date' => $produit->getDate(),
                ':image' => $produit->getImage(),
            ]);
        } catch (PDOException $e) {
            // Afficher les détails de l'erreur
            die('Erreur SQL : ' . $e->getMessage());
        }
    }
    
    function deleteProduit($id)
    {
        $sql = "DELETE FROM PRODUITV WHERE id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    function updateProduit($produit, $id)
    {   
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE PRODUITV SET 
                        nom = :nom, 
                        pass = :pass, 
                        description = :description,
                        lieu = :lieu,
                        date = :date';
            $params = [
                'nom' => $produit->getNom(),
                'pass' => $produit->getPass(),
                'description' => $produit->getDescription(),
                'lieu' => $produit->getLieu(),
                'date' => $produit->getDate(),
                'id' => $id
            ];
            if ($produit->getImage() !== null) {
                $sql .= ', image = :image';
                $params['image'] = $produit->getImage();
            }
            $sql .= ' WHERE id = :id';
            $query = $db->prepare($sql);
            $query->execute($params);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
}
