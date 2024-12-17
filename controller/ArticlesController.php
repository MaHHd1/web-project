<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Articles.php');

class ArticlesController
{
    public function listArticles()
    {
        $sql = "SELECT * FROM articles"; 
        $db = config::getConnexion(); 
        try {
            $stmt = $db->query($sql); 
            $liste = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
            if (empty($liste)) {
                // Si la liste est vide, retourner un tableau vide ou un message d'erreur
                return [];
            }
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    
    public function updateLikeDislike($articleId, $action) {
        $db = config::getConnexion(); // Utilisation de config::getConnexion()
        try {
            if ($action === 'like') {
                $query = "UPDATE articles SET likes = likes + 1 WHERE id = :id";
            } elseif ($action === 'dislike') {
                $query = "UPDATE articles SET dislikes = dislikes + 1 WHERE id = :id";
            } else {
                throw new Exception("Action invalide : $action");
            }

            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteArticles($id)
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
    {
        $sql = "INSERT INTO articles (titre, contenu_txt, contenu_img, date_creation)
            VALUES (:titre, :contenu_txt, :contenu_img, :date_creation)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'titre' => $offer->getTitre(),
                'contenu_txt' => $offer->getContenu_txt(),
                'contenu_img' => $offer->getContenu_img(),
                'date_creation' => $offer->getDate_creation()->format('Y-m-d')
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateArticles($offer, $id)
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
                'titre' => $offer->getTitre(),
                'contenu_txt' => $offer->getContenu_txt(),
                'contenu_img' => $offer->getContenu_img(),
                'date_creation' => $offer->getDate_creation()->format('Y-m-d')
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
    public function showArticleWithComments($id_article)
    {
        $sql_article = "SELECT * FROM articles WHERE id = :id";
        $db = config::getConnexion();
        try {
            $req_article = $db->prepare($sql_article);
            $req_article->bindValue(':id', $id_article);
            $req_article->execute();
            $article = $req_article->fetch();
    
            if (!$article) {
                // Si l'article n'est pas trouvé, on retourne null
                return null;
            }
    
            // Récupérer les commentaires associés à l'article
            $sql_comments = "SELECT * FROM commentaires WHERE id_articles = :id_articles";
            $req_comments = $db->prepare($sql_comments);
            $req_comments->bindValue(':id_articles', $id_article);
            $req_comments->execute();
            $comments = $req_comments->fetchAll(PDO::FETCH_ASSOC);
    
            return ['article' => $article, 'comments' => $comments];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
   
   
            
                