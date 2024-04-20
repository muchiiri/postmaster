<?php
require_once 'UserModel.php';
require_once 'DatabaseConnection.php';

class UserController {
    private $userModel;

    public function __construct($dbConnection) {
        $this->userModel = new UserModel($dbConnection);
    }

    public function createUser($username, $password, $user_type) {
        $result = $this->userModel->createUser($username, $password, $user_type);
        echo $result ? 'User created successfully' : 'Failed to create user';
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

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

// Passing the PDO connection to your class
$UserModel = new UserModel($pdoConnection);
?>
