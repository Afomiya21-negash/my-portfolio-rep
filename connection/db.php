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

        // Create `projects` table
        $projectsTable = "CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url_link VARCHAR(255),
            picture VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if (
            !$this->conn->query($aboutTable) ||
            !$this->conn->query($experienceTable) ||
            !$this->conn->query($projectsTable)
        ) {
            die("Error creating tables: " . $this->conn->error);
        }
    }

    // Manage `about` table (CRUD Operations)
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

    // Manage `experience` table (CRUD Operations)
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

    // Manage `projects` table (CRUD Operations)
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
}

// Create the database instance
$db = new Database();
?>
