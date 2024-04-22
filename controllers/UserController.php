<?php
require_once '../models/UserModel.php';
require_once '../models/DatabaseConnection.php';

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

class UserController {
    private $userModel;

    public function __construct($dbConnection) {
        $this->userModel = new UserModel($dbConnection);
    }

    public function createUser($username, $password, $user_type) {
        $result = $this->userModel->createUser($username, $password, $user_type);
        if ($result) {
            // Check user type and redirect accordingly
            if ($user_type === 'admin') {
                header('Location: ../views/users/list.php');
            } else if ($user_type === 'delivery_user') {
                header('Location: ../views/parcels/list.php');
            }
            exit; // Ensure no further execution after redirection
        } else {
            echo 'Failed to create user';
        }
    }

    public function getUserById($user_id) {
        $user = $this->userModel->getUserById($user_id);
        echo $user ? json_encode($user) : 'User not found';
    }

    public function updateUser($user_id, $username, $password, $user_type) {
        $result = $this->userModel->updateUser($user_id, $username, $password, $user_type);
        echo $result ? 'User updated successfully' : 'Failed to update user';
    }

    public function deleteUser($user_id) {
        $result = $this->userModel->deleteUser($user_id);
        echo $result ? 'User deleted successfully' : 'Failed to delete user';
    }

    public function getAllUsers() {
        $users = $this->userModel->getAllUsers();
        echo json_encode($users);
    }
}

// Check if the script is accessed via a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instantiate the UserController with the database connection
    $userController = new UserController($pdoConnection);

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Call createUser method
    $userController->createUser($username, $password, $user_type);
}
?>
