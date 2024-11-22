<?php
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/config.php';

class LoginController
{
    private $db;

    public function __construct()
    {
        global $pdo;
        $this->db = $pdo;
    }

    public function signin(User $user)
    {
        $mail = $user->getMail();
        $psw = $user->getPsw();


        $query = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($userData) {
            // Verify the password
            if (password_verify($psw, $userData['psw'])) {
                session_start(); // Start the session
                $_SESSION['user_id'] = $userData['id']; // Store user ID
                echo "Signin successful!";
                return true;
            } else {
                echo "Incorrect password!";
                return false;
            }
        } else {
            echo "No user found with that email!";
            return false;
        }
    }



    public function disconnect()
    {
        session_start(); // Start the session
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: login.php");
        exit();
    }
    public function signup(User $user)
    {
        $email = $user->getMail();
        $password = $user->getPsw();

        // Check if the email already exists
        $query = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mail', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Email already exists
            return false;
        }

        // Insert the new user
        $insertQuery = "INSERT INTO user (mail, psw) VALUES (:mail, :psw)";
        $insertStmt = $this->db->prepare($insertQuery);
        $insertStmt->bindParam(':mail', $email);
        $insertStmt->bindParam(':psw', $password);

        return $insertStmt->execute();
    }


}
?>





