<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/ArticleModel.php');

class ArticleController
{
    public function listArticle() // Changez le nom pour correspondre à l'appel dans blog.php
    {
        $sql = "SELECT * FROM Articles"; // Assurez-vous que le nom de la table est correct
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(PDO::FETCH_ASSOC); // Utilisez fetchAll pour retourner un tableau associatif
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function deleteArticle($id)
    {
        $sql = "DELETE FROM articles WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addArticle($offer)
    {   var_dump($offer);
        $sql = "INSERT INTO articles  
        VALUES (NULL, :titre,:contenu_txt, :contenu_img,:date_creation)";
        $db = config::getConnexion();
        try {
            
            $query = $db->prepare($sql);
            $query->execute([
                'titre' => $offer->getTitre(),
                'contenu_txt' => $offer->getContenuTxt(),
                'contenu_img' => $offer->getContenuImg(), 
                'date_creation' => $offer->getDateCreation()->format('Y-m-d')
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateArticle($offer, $id)
{
    var_dump($offer);
    try {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE articles SET 
                titre = :titre,
                contenu_txt = :contenu_txt,
                contenu_img = :contenu_img,
                date_creation = :date_creation
            WHERE id = :id'
        );

        $query->execute([
            'id' => $id,
            'titre' => $offer['titre'], // Accès via indices du tableau
            'contenu_txt' => $offer['contenu_txt'],
            'contenu_img' => $offer['contenu_img'],
            'date_creation' => $offer['date_creation']
        ]);

        echo $query->rowCount() . " records UPDATED successfully <br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }
}


    function showArticle($id)
    {
        $sql = "SELECT * from articles where id = $id";
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
