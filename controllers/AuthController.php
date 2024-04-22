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
            // Assuming the user role is also stored in session or returned by login method
            // For example, let's say it's stored in session
            $userRole = $_SESSION['user_type']; // Make sure this is set in your login method

            // Redirect based on user role
            if ($userRole == 'admin') {
                header("Location: ../dashboard.php");
            } else if ($userRole == 'delivery_user') {
                header("Location: ../dashboard_delivery.php"); // Assuming you have a separate dashboard for delivery users
            }
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
