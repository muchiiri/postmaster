<?php
require_once '../../models/DatabaseConnection.php';
require_once '../../models/PointModel.php';

// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

// Instantiate the PointModel with the database connection
$pointModel = new PointModel($pdoConnection);

// Fetch all recipients directly using the model
$recipients = $pointModel->getAllRecipients();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Recipients</title>
</head>
<body>
    <h2>List of Recipients</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Postal Code</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Actions</th> <!-- Add a header for the actions -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipients as $recipient): ?>
            <tr>
                <td><?php echo htmlspecialchars($recipient['point_id']); ?></td>
                <td><?php echo htmlspecialchars($recipient['recipient_name']); ?></td>
                <td><?php echo htmlspecialchars($recipient['recipient_address']); ?></td>
                <td><?php echo htmlspecialchars($recipient['recipient_postalcode']); ?></td>
                <td><?php echo htmlspecialchars($recipient['longitude_point']); ?></td>
                <td><?php echo htmlspecialchars($recipient['latitude_point']); ?></td>
                <td>
                    <!-- Add an Edit button/link for each recipient -->
                    <a href="update.php?id=<?php echo htmlspecialchars($recipient['point_id']); ?>">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
