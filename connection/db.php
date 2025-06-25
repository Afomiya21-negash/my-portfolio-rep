<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";   
    private $dbName = "portfolio";
    public $conn;

    public function __construct() {
        $this->connect();
        $this->createDatabase();
        $this->createTables();
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function createDatabase() {
        $sql = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        if ($this->conn->query($sql) === TRUE) {
            // echo "Database created successfully or already exists.<br>";
        } else {
            die("Error creating database: " . $this->conn->error);
        }

        $this->conn->select_db($this->dbName);
    }

    private function createTables() {
        $heroTable = "CREATE TABLE IF NOT EXISTS hero (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        // Create `about` table
        $aboutTable = "CREATE TABLE IF NOT EXISTS about (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        // Create `experience` table
        $experienceTable = "CREATE TABLE IF NOT EXISTS experience (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

       
        $projectsTable = "CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url_link VARCHAR(255),
            picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $contactTable = "CREATE TABLE IF NOT EXISTS contact (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url_link VARCHAR(255),
            picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        // Add users table
        $usersTable = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if (
            !$this->conn->query($heroTable) ||
            !$this->conn->query($aboutTable) ||
            !$this->conn->query($experienceTable) ||
            !$this->conn->query($projectsTable) ||
            !$this->conn->query($contactTable) ||
            !$this->conn->query($usersTable)
        ) {
            die("Error creating tables: " . $this->conn->error);
        }
        
        // Check if admin user exists, if not create it
        $this->createAdminUserIfNotExists();
    }

    private function createAdminUserIfNotExists() {
        $sql = "SELECT * FROM users WHERE username = 'mia'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows == 0) {
            // Admin user doesn't exist, create it
            $username = "mia";
            $password = password_hash("1738AMN@lafto", PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
        }
    }

    // Manage hero,about,experince and project table 
    public function managehero($action, $id = null, $title = null, $description = null, $picture = null) {
        switch ($action) {
            case 'create':
                $sql = "INSERT INTO hero (title, description, picture) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $title, $description, $picture);
                return $stmt->execute();

            case 'read':
                $sql = "SELECT * FROM hero";
                return $this->conn->query($sql);

            case 'update':
                $sql = "UPDATE hero SET title=?, description=?, picture=? WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $title, $description, $picture, $id);
                return $stmt->execute();

            case 'delete':
                $sql = "DELETE FROM hero WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }
    public function manageAbout($action, $id = null, $title = null, $description = null, $picture = null) {
        switch ($action) {
            case 'create':
                $sql = "INSERT INTO about (title, description, picture) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $title, $description, $picture);
                return $stmt->execute();

            case 'read':
                $sql = "SELECT * FROM about";
                return $this->conn->query($sql);

            case 'update':
                $sql = "UPDATE about SET title=?, description=?, picture=? WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $title, $description, $picture, $id);
                return $stmt->execute();

            case 'delete':
                $sql = "DELETE FROM about WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }

    
    public function manageExperience($action, $id = null, $title = null, $description = null) {
        switch ($action) {
            case 'create':
                $sql = "INSERT INTO experience (title, description) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ss", $title, $description);
                return $stmt->execute();

            case 'read':
                $sql = "SELECT * FROM experience";
                return $this->conn->query($sql);

            case 'update':
                $sql = "UPDATE experience SET title=?, description=? WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssi", $title, $description, $id);
                return $stmt->execute();

            case 'delete':
                $sql = "DELETE FROM experience WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }

    
    public function manageProject($action, $id = null, $title = null, $url_link = null, $picture = null) {
        switch ($action) {
            case 'create':
                $sql = "INSERT INTO projects (title, url_link, picture) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $title, $url_link, $picture);
                return $stmt->execute();

            case 'read':
                $sql = "SELECT * FROM projects";
                return $this->conn->query($sql);

            case 'update':
                $sql = "UPDATE projects SET title=?, url_link=?, picture=? WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $title, $url_link, $picture, $id);
                return $stmt->execute();

            case 'delete':
                $sql = "DELETE FROM projects WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }
    public function managecontact($action, $id = null, $title = null, $url_link = null, $picture = null) {
        switch ($action) {
            case 'create':
                $sql = "INSERT INTO contact ( title,url_link, picture) VALUES (?,?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $title, $url_link, $picture);
                return $stmt->execute();

            case 'read':
                $sql = "SELECT * FROM contact ";
                return $this->conn->query($sql);

            case 'update':
                $sql = "UPDATE contact SET title=?, url_link=?, picture=? WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $title, $url_link, $picture, $id);
                return $stmt->execute();

            case 'delete':
                $sql = "DELETE FROM contact WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }
    
    // Add a method to manage users
    public function manageUsers($action, $id = null, $username = null, $password = null, $email = null) {
        switch ($action) {
            case 'create':
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $username, $hashedPassword, $email);
                return $stmt->execute();
                
            case 'read':
                $sql = "SELECT id, username, email, created_at FROM users";
                return $this->conn->query($sql);
                
            case 'get':
                $sql = "SELECT * FROM users WHERE username = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                return $stmt->get_result();
                
            case 'update':
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET username=?, password=?, email=? WHERE id=?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sssi", $username, $hashedPassword, $email, $id);
                } else {
                    $sql = "UPDATE users SET username=?, email=? WHERE id=?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ssi", $username, $email, $id);
                }
                return $stmt->execute();
                
            case 'delete':
                $sql = "DELETE FROM users WHERE id=?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $id);
                return $stmt->execute();
        }
    }
    
}


$db = new Database();
?>
