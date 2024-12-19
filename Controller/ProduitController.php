<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Models/produit.php');

class ProduitController
{
    public function listProduit()
    {
        $sql = "SELECT * FROM produit";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteProduit($id)
    {
        $sql = "DELETE FROM produit WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addProduit($produit)
    {
        $sql = "INSERT INTO produit (nomproduit, prix, quantite, image) 
                VALUES (:nomproduit, :prix, :quantite, :image)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nomproduit' => $produit->getNomProduit(),
                'prix' => $produit->getPrix(),
                'quantite' => $produit->getQuantite(),
                'image' => $produit->getImage()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    function updateProduit($offer, $id)
{
    try {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE produit SET 
                nomproduit = :nomproduit,
                prix = :prix,
                quantite = :quantite,
                image = :image
            WHERE id = :id'
        );

        $query->execute([
            'id' => $id,
            'nomproduit' => $offer->getNomProduit(),
            'prix' => $offer->getPrix(),
            'quantite' => $offer->getQuantite(), 
            'image' => $offer->getImage(),
        ]);

        echo $query->rowCount() . " records UPDATED successfully <br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }
}



    function showProduit($id)
    {
        $sql = "SELECT * from produit where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $offer = $query->fetch();
            return $offer;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}