<?php
class Database {
    private $host = 'localhost';        // Database server
    private $db_name = 'farmnet'; // Database name
    private $username = 'root';         // Database username
    private $password = '';             // Database password
    private $conn;

    /**
     * Establishes and returns the database connection.
     *
     * @return PDO|null The PDO instance or null on failure.
     */
    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
 