<?php
class AuthModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Register a new user
    public function register($username, $password, $user_type) {
        // Check if the username already exists
        $checkSql = "SELECT username FROM users WHERE username = ?";
        $stmt = $this->db->prepare($checkSql);
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            return false; // Username already exists
        }

        // Hash password and insert the new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$username, $hashedPassword, $user_type]);
        return $result;
    }

    // Log in a user
    public function login($username, $password) {
        $sql = "SELECT user_id, username, password, user_type FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // If password matches, set up session
            session_regenerate_id();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['logged_in'] = true;
            return true;
        }
        return false;
    }

    // Check if the user is logged in
    public function isUserLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    // Log out a user
    public function logout() {
        // Destroy the session
        session_start();
        $_SESSION = array();
        session_destroy();
    }
}
?>
