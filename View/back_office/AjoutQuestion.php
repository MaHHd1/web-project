<?php
// Configuration de la base de données
$host = "localhost";         // Remplacez par votre hôte (ex: localhost)
$dbname = "forum";           // Nom de votre base de données
$username = "root";          // Votre nom d'utilisateur (par défaut: root)
$password = "";              // Votre mot de passe (vide par défaut sur XAMPP)

// Gestion de la connexion et traitement des données
try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        

        // Validation des champs obligatoires
        if (empty($titre) || empty($contenu)) {
            echo "<p style='color: red;'>Erreur : Le titre et le contenu sont requis !</p>";
        } else {
            // Insérer les données dans la table Question
            $sql = "INSERT INTO Question (titre, contenu) VALUES (:titre, :contenu)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'titre' => $titre,
                'contenu' => $contenu,
            ]);

            // Afficher un message de confirmation
            echo "<p style='color: green;'>Question ajoutée avec succès !</p>";
        }
    }
} catch (PDOException $e) {
    // Gérer les erreurs de connexion ou d'exécution
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Question</title>
    <style>
        /* CSS intégré */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        input, textarea {
            width: 100%;
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Ajouter une Question</h1>
        <form action="" method="POST">
            
            
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" placeholder="Entrez le titre de la question" required>
            
            <label for="contenu">Contenu :</label>
            <textarea id="contenu" name="contenu" rows="6" placeholder="Entrez les détails de votre question" required></textarea>
            
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
