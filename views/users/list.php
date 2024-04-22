
<?php
session_start(); // Start the session at the beginning

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../../index.php'); // Adjust the path to your login page as necessary
    exit;
}

require_once '../../models/DatabaseConnection.php';
require_once '../../models/UserModel.php';

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

// Instantiate the UserModel with the database connection
$userModel = new UserModel($pdoConnection);

// Fetch all users
$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <!-- Add any additional CSS or JS here -->
</head>
<body>
<a href="../../controllers/AuthController.php?action=logout">Logout</a>
    <h1>User List</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['user_type']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
