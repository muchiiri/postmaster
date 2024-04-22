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

// Check user role and fetch parcels accordingly
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'delivery_user') {
    $username = $_SESSION['username']; // Assuming the username is stored in session
    $parcels = $parcelModel->getParcelsByDeliveryUser($username);
} else {
    $parcels = $parcelModel->getAllParcels();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parcel List</title>
    <!-- Add any additional CSS or JS here -->
</head>
<body>
<a href="../../controllers/AuthController.php?action=logout">Logout</a>
    <h1>Parcel List</h1>
    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin'): ?>
    <a href="create.php">Create New Parcel</a> |
    <a href="../points/create.php">Create New Recipient</a> |
    <a href="../points/list.php">List Recipients</a> |
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Parcel ID</th>
                <th>Delivery User</th>
                <th>Recipient</th> <!-- New column for recipient -->
                <th>Action</th> <!-- New column for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parcels as $parcel): ?>
            <tr>
                <td><?php echo htmlspecialchars($parcel['parcel_id']); ?></td>
                <td><?php echo htmlspecialchars($parcel['delivery_user']); ?></td>
                <td><?php echo htmlspecialchars($parcel['recipient_name']); ?></td> <!-- Display recipient name -->
                <td><a href="update.php?parcel_id=<?php echo $parcel['parcel_id']; ?>">Edit</a></td> <!-- Edit button -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
