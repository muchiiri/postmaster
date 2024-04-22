<?php
session_start(); // Start the session at the beginning

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../../index.php'); // Adjust the path to your login page as necessary
    exit;
}

require_once '../../models/DatabaseConnection.php';
require_once '../../models/ParcelModel.php';

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

// Instantiate the ParcelModel with the database connection
$parcelModel = new ParcelModel($pdoConnection);

// Fetch all parcels
$parcels = $parcelModel->getAllParcels();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parcel List</title>
    <!-- Add any additional CSS or JS here -->
</head>
<body>
    <h1>Parcel List</h1>
    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin'): ?>
        <a href="create_parcel.php">Create New Parcel</a> |
    <?php endif; ?>
    <a href="../../controllers/AuthController.php?action=logout">Logout</a>
    <table>
        <thead>
            <tr>
                <th>Parcel ID</th>
                <th>Delivery User</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parcels as $parcel): ?>
            <tr>
                <td><?php echo htmlspecialchars($parcel['parcel_id']); ?></td>
                <td><?php echo htmlspecialchars($parcel['delivery_user']); ?></td>
                <!-- Output more parcel details as needed -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
