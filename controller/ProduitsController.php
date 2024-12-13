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
    public function listProduitsByDateClosest($start = 0, $limit = 10)
{
    try {
        $pdo = connexion::getConnexion();

        $sql = "SELECT * FROM produitv 
                WHERE date >= CURDATE() 
                ORDER BY date ASC 
                LIMIT :start, :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('PDO Error: ' . $e->getMessage());
    }
}


    public function listProduitsByPrice($order = 'ASC', $start = 0, $limit = 10) {
        try {
            $pdo = connexion::getConnexion();
    
            $sql = "SELECT * FROM produitv ORDER BY pass $order LIMIT :start, :limit";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        }
    }
    
    

    public function listProduitPaginated($start, $limit)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $query = $pdo->prepare("SELECT * FROM produitv LIMIT :start, :limit");
            $query->bindValue(':start', (int)$start, PDO::PARAM_INT);
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listProduitByDate($date, $start, $limit)
    {
        try {
            $pdo = connexion::getConnexion();
            $query = "SELECT * FROM produits WHERE date = :date LIMIT :start, :limit";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        }
    }

    public function countProduitByDate($date)
    {
        try {
            $pdo = connexion::getConnexion();
            $query = "SELECT COUNT(*) FROM produits WHERE date = :date";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        }
    }

    public function getReservationsByEvent($id)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $query = $pdo->prepare("SELECT * FROM reservation WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
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
        try {
            $sql = "INSERT INTO PRODUITV (nom, description, pass, lieu, date, image, datef) VALUES (:nom, :description, :pass, :lieu, :date, :image, :datef)";
            $db = connexion::getConnexion();
            $query = $db->prepare($sql);
            $query->execute([
                ':nom' => $produit->getNom(),
                ':description' => $produit->getDescription(),
                ':pass' => $produit->getPass(),
                ':lieu' => $produit->getLieu(),
                ':date' => $produit->getDate(),
                ':image' => $produit->getImage(),
                ':datef' => $produit->getDatef(),
            ]);
        } catch (PDOException $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }
    }

    public function deleteProduit($id)
    {
        try {
            $sql = "DELETE FROM PRODUITV WHERE id = :id";
            $db = connexion::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id', $id);
            $req->execute();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateProduit($produit, $id)
    {
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE PRODUITV SET 
                        nom = :nom, 
                        pass = :pass, 
                        description = :description,
                        lieu = :lieu,
                        date = :date,
                        datef = :datef';

            $params = [
                'nom' => $produit->getNom(),
                'pass' => $produit->getPass(),
                'description' => $produit->getDescription(),
                'lieu' => $produit->getLieu(),
                'date' => $produit->getDate(),
                'datef' => $produit->getDatef(),
                'id' => $id
            ];

            if ($produit->getImage() !== null) {
                $sql .= ', image = :image';
                $params['image'] = $produit->getImage();
            }

            $sql .= ' WHERE id = :id';
            $query = $db->prepare($sql);
            $query->execute($params);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        }
    }

    // Nouvelle méthode pour rechercher des produits par nom
    public function searchProduitsByName($searchTerm, $start, $limit)
    {
        try {
            $pdo = connexion::getConnexion();
            $query = "SELECT * FROM produitv WHERE nom LIKE :searchTerm LIMIT :start, :limit";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
