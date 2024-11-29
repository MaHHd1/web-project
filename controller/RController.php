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

    public function getReservationById($id_reservation)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM reservation WHERE id_reservation = :id_reservation");
            $query->execute(['id_reservation' => $id_reservation]);
            return $query->fetch();
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
            $sql = "INSERT INTO reservation (id, nom_p, numero, mail) VALUES (:id, :nom_p, :numero, :mail)";
            $query = $db->prepare($sql);
            $query->execute([
                ':id' => $reservation->getId(),
                ':nom_p' => $reservation->getNomP(),
                ':numero' => $reservation->getNumero(),
                ':mail' => $reservation->getMail(),
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
                        mail = :mail
                    WHERE id_reservation = :id_reservation';
            $query = $db->prepare($sql);
            $query->execute([
                ':id' => $reservation->getId(),
                ':nom_p' => $reservation->getNomP(),
                ':numero' => $reservation->getNumero(),
                ':mail' => $reservation->getMail(),
                ':id_reservation' => $id_reservation,
            ]);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
