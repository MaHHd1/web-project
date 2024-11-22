<?php
require_once __DIR__ . '/../Model/userModel.php';  // Include the User model
require_once __DIR__ . '/../Model/config.php';  // Include the database config

class UserController
{
    private $db;
    private $userModel;

    // Constructor to initialize the database connection and model
    public function __construct()
    {
        global $pdo;  // Use the global $pdo variable from config.php
        $this->db = $pdo;  // Set the PDO instance from config.php
        $this->userModel = new User();  // Initialize the User model
    }

    // Signup method to register a new user
    public function signup(User $user)
    {
        $name = $user->getName();
        $mail = $user->getMail();
        $psw = $user->getPsw();

        // Check if the email already exists
        $query = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Email already registered!";
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($psw, PASSWORD_DEFAULT);

        // Insert the user into the database
        try {
            $query = "INSERT INTO user (name, mail, psw) VALUES (:name, :mail, :psw)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':psw', $hashedPassword);  // Store the hashed password
            $stmt->execute();
            echo "User registered successfully!";
            return true;
        } catch (PDOException $e) {
            echo "Failed to register user: " . $e->getMessage();
            return false;
        }
    }

    // Signin method to authenticate a user
    public function signin(User $user)
    {
        $mail = $user->getMail();
        $psw = $user->getPsw();

        // Query to check if the user exists in the database
        $query = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user exists
        if ($userData) {
            // Verify the password
            if (password_verify($psw, $userData['psw'])) {
                echo "Signin successful!";
                session_start();
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['name'] = $userData['name'];
                $_SESSION['mail'] = $userData['mail'];
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
        // Start the session to access session variables
        session_start();

        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Optionally, redirect the user to a different page after logout (e.g., home page or login page)
        header("Location: login.php");  // Redirect to the homepage or login page
        exit();
    }

}
?>
