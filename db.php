<?php   
class Connexion
{
    private static $pdo = null;
    
    public static function getConnexion()
    {
        $servername = "localhost";
        $dbname = 'farmnet'; // Replace 'db' with your actual database name
        $username = 'root';
        $password = '';
        
        try {
            self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        return self::$pdo;
    }
}
?>