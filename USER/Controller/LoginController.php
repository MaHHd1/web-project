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

    // User Signin
    // User Signin
    public function signin(User $user)
    {
        $email = $user->getMail();
        $password = $user->getPsw();

        // Fetch user from database by email
        $stmt = $this->db->prepare("SELECT * FROM users WHERE mail = :mail");
        $stmt->bindParam(':mail', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Compare the hashed password with the input password
            if (password_verify($password, $result['psw'])) {
                session_start(); // Start the session
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['user_email'] = $result['mail'];
                $_SESSION['user_privilege'] = $result['privilege'];

                // Generate a session ID and expiration time
                $session_id = session_id(); // Get the session ID
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Set session expiration (1 hour from now)

                // Update session ID and expiration in the database
                $updateSessionQuery = "UPDATE users SET session_id = :session_id, session_expires_at = :expires_at WHERE id = :id";
                $stmt = $this->db->prepare($updateSessionQuery);
                $stmt->bindParam(':session_id', $session_id);
                $stmt->bindParam(':expires_at', $expires_at);
                $stmt->bindParam(':id', $result['id']);
                $stmt->execute();

                // Redirect based on the user's privilege
                if ($result['privilege'] == 1) {
                    return 'admin'; // Admin user
                } else {
                    return 'user'; // Regular user
                }
            } else {
                return false; // Invalid password
            }
        } else {
            return false; // User not found
        }
    }


    // User Logout
    // User Logout
    public function disconnect()
    {
        session_start();
        session_unset();
        session_destroy();

        // Remove session_id and session_expires_at from the database
        $stmt = $this->db->prepare("UPDATE users SET session_id = NULL, session_expires_at = NULL WHERE id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        // Remove session cookie
        setcookie("session_id", "", time() - 3600, "/"); // Expire the cookie immediately

        header("Location: login.php");
        exit();
    }


    // Check if the user is logged in by checking session or cookies
    // Check if the user is logged in by checking session or cookies
    public function checkLogin()
    {
        session_start();

        // Retrieve session ID from the client-side cookie
        $session_id = $_COOKIE['session_id'] ?? null;

        if ($session_id) {
            // Fetch user session from database based on the session_id
            $stmt = $this->db->prepare("SELECT * FROM users WHERE session_id = :session_id AND session_expires_at > NOW()");
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // The session is valid and not expired
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['mail'];
                $_SESSION['user_privilege'] = $user['privilege'];

                return true; // User is logged in
            }
        }

        return false; // Session does not exist or is expired
    }


    // Get user data from session or cookies
    public function getUserData()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'],
                'privilege' => $_SESSION['user_privilege'],
            ];
        }
        return null;
    }

    // Add a new user
    public function addUser(User $user)
    {
        try {
            $email = $user->getMail();
            $password = password_hash($user->getPsw(), PASSWORD_DEFAULT);
            $uname = $user->getUname();
            $country = $user->getCountry();

            // Check if the user already exists in the database
            $query = "SELECT * FROM users WHERE mail = :mail";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mail', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "User with this email already exists!";
                return false;
            }

            // Insert the new user into the database
            $insertQuery = "INSERT INTO users (mail, psw, Uname, Country) VALUES (:mail, :psw, :uname, :country)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':mail', $email);
            $insertStmt->bindParam(':psw', $password);
            $insertStmt->bindParam(':uname', $uname);
            $insertStmt->bindParam(':country', $country);

            if ($insertStmt->execute()) {
                echo "User added successfully!";
                return true;
            } else {
                echo "Error adding user!";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a user by email
    public function deleteUser($userId) {
        // Prepare the SQL statement to delete the user by ID
        $query = "DELETE FROM users WHERE id = :userId"; // Ensure your table name and column names are correct
        $stmt = $this->db->prepare($query);

        // Bind the user ID to the SQL query
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error: User could not be deleted.";
        }
    }

    // Update profile image
    public function updateProfileImage($id, $imagePath)
    {
        global $pdo;
        $query = "UPDATE users SET IMG = :img WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':img', $imagePath, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Update user profile (Uname, Country)
    public function updateUserProfile($id, $uname, $country)
    {
        global $pdo;
        $query = "UPDATE users SET Uname = :uname, Country = :country WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':uname', $uname, PDO::PARAM_STR);
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Update user (email, password, uname, country)
    public function updateUser($id, $email, $password, $uname, $country)
    {
        global $pdo;
        $query = "UPDATE users SET mail = :mail, psw = :psw, Uname = :uname, Country = :country WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':mail', $email);
        $stmt->bindParam(':psw', $password);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Fetch user details by ID
    public function getUserById($userId)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userData;
    }
    public function registerUser($email, $passwordHash, $privilege)
    {
        try {
            // Check if the email already exists
            $query = "SELECT * FROM users WHERE mail = :mail";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':mail', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return false; // User with this email already exists
            }

            // Insert new user
            $insertQuery = "INSERT INTO users (mail, psw, privilege) VALUES (:mail, :psw, :privilege)";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':mail', $email);
            $insertStmt->bindParam(':psw', $passwordHash);
            $insertStmt->bindParam(':privilege', $privilege);
            return $insertStmt->execute();
        } catch (Exception $e) {
            return false; // Handle exceptions (e.g., database errors)
        }
    }
    public function getAdminDetails($email) {
        // Fetch admin details where privilege = 1 from the users table
        $query = "SELECT Uname, IMG FROM users WHERE mail = :email AND privilege = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Return the fetched admin details
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllUsers() {
        // Query to fetch all users from the 'users' table
        $query = "SELECT * FROM users";  // Adjust query as necessary for your table structure
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Fetch all the users as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>
