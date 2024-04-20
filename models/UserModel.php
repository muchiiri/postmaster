<?php
require_once 'DatabaseConnection.php';

class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Create a new user
    public function createUser($username, $password, $user_type) {
        $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $passwordHash, $user_type]);
    }

    // Retrieve a user by ID
    public function getUserById($user_id) {
        $sql = "SELECT user_id, username, user_type FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a user's information
    public function updateUser($user_id, $username, $password, $user_type) {
        $sql = "UPDATE users SET username = ?, password = ?, user_type = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $passwordHash, $user_type, $user_id]);
    }

    // Delete a user
    public function deleteUser($user_id) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id]);
    }

    // List all users
    public function getAllUsers() {
        $sql = "SELECT user_id, username, user_type FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

// Passing the PDO connection to your class
$UserModel = new UserModel($pdoConnection);
?>
