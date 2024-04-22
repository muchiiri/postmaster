<?php
session_start();
require_once '../models/AuthModel.php';
require_once '../models/DatabaseConnection.php';

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

class AuthController {
    private $authModel;

    public function __construct($dbConnection) {
        $this->authModel = new AuthModel($dbConnection);
    }

    public function login($username, $password) {
        $result = $this->authModel->login($username, $password);
        if ($result) {
            // Login successful
            $_SESSION['username'] = $username;
            // You can also set other session variables as needed, e.g., user type
            header("Location: ../views/parcels/list.php"); // Redirect to a dashboard or home page
            exit();
        } else {
            // Login failed
            echo "Login failed. Please check your username and password.";
            // Optionally, redirect back to the login page or show an error message
        }
    }

    public function logout() {
        // Clear the session
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        // Redirect to login page
        header("Location: ../index.php");
        exit();
    }
}

// Check if the script is accessed via a POST request or a logout request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authController = new AuthController($pdoConnection);
    $authController->login($username, $password);
} elseif (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $authController = new AuthController($pdoConnection);
    $authController->logout();
}
?>
