<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../Model/R.php';

class ReservationController
{
    public function listReservations()
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM reservation");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getReservationsByEvent($idP) {
        try {
            $pdo = connexion::getConnexion();
            // Remplacez 'product_id' par 'event_id' si tel est le nom correct de la colonne
            $query = $pdo->prepare("SELECT * FROM reservation WHERE id = :idP");
            $query->execute([':idP' => $idP]);
            $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
            
            return $reservations;
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    
    
    public function getReservationById($id_reservation)
{
    try {
        $db = connexion::getConnexion();

        if (!$db) {
            throw new Exception("Failed to connect to the database.");
        }

        $sql = "SELECT * FROM reservation WHERE id_reservation = :id_reservation";
        $query = $db->prepare($sql);
        $query->execute([':id_reservation' => $id_reservation]);
        $reservation = $query->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            return null; // Retourne null si aucune réservation n'est trouvée
        }

        return $reservation;
    } catch (PDOException $e) {
        die('PDO Error: ' . $e->getMessage());
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

    

    public function getReservationsByProductId($productId)
    {
        try {
            $pdo = connexion::getConnexion();
    
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
    
            $query = $pdo->prepare("SELECT * FROM reservation WHERE product_id = :product_id");
            $query->execute(['product_id' => $productId]);
            $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
    
            if (empty($reservations)) {
                return []; // Retourne un tableau vide si aucune donnée trouvée
            }
    
            return $reservations;
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

    public function addReservation(Reservation $reservation)
    {
        try {
            $db = connexion::getConnexion();
            $sql = "INSERT INTO reservation (id, nom_p, numero, mail,quantite) VALUES (:id, :nom_p, :numero, :mail, :quantite)";
            $query = $db->prepare($sql);
            $query->execute([
                ':id' => $reservation->getId(),
                ':nom_p' => $reservation->getNomP(),
                ':numero' => $reservation->getNumero(),
                ':mail' => $reservation->getMail(),
                ':quantite' => $reservation->getQuantite(),
            ]);
            echo "Réservation ajoutée avec succès.";
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }


    public function deleteReservation($id_reservation)
    {
        $sql = "DELETE FROM reservation WHERE id_reservation = :id_reservation";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_reservation', $id_reservation);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function updateReservation($reservation, $id_reservation)
    {
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE reservation SET 
                        id = :id, 
                        nom_p = :nom_p, 
                        numero = :numero,
                        mail = :mail,
                        quantite = :quantite
                    WHERE id_reservation = :id_reservation';
            $query = $db->prepare($sql);
            $query->execute([
                ':id' => $reservation->getId(),
                ':nom_p' => $reservation->getNomP(),
                ':numero' => $reservation->getNumero(),
                ':mail' => $reservation->getMail(),
                ':quantite' => $reservation->getQuantite(),
                ':id_reservation' => $id_reservation,
            ]);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
