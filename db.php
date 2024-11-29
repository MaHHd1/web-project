<?php   
class Connexion
{
    private static $pdo = null;
    
    public static function getConnexion()
    {
        $servername = "localhost";
        $dbname ="produitv";
        $username ="root";
        $password ="";
        
        try {
            self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            echo "You are connected.";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        return self::$pdo;
    }
}
?>