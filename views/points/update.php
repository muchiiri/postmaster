<?php
require_once '../../models/DatabaseConnection.php';
require_once '../../models/PointModel.php';

$pdoConnection = DatabaseConnection::getPDOConnection();
$pointModel = new PointModel($pdoConnection);

// Get recipient ID from query string
$point_id = isset($_GET['id']) ? $_GET['id'] : '';

// Fetch recipient data
$recipient = $pointModel->getRecipientById($point_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipient</title>
</head>
<body>
    <h2>Edit Recipient</h2>
    <form action="../../controllers/PointController.php" method="post">
    <input type="hidden" name="operation" value="update">
        <input type="hidden" name="point_id" value="<?php echo htmlspecialchars($recipient['point_id']); ?>">
        Name: <input type="text" name="recipient_name" value="<?php echo htmlspecialchars($recipient['recipient_name']); ?>" required><br>
        Address: <input type="text" name="recipient_address" value="<?php echo htmlspecialchars($recipient['recipient_address']); ?>" required><br>
        Postal Code: <input type="text" name="recipient_postalcode" value="<?php echo htmlspecialchars($recipient['recipient_postalcode']); ?>" required><br>
        Longitude: <input type="text" name="longitude_point" value="<?php echo htmlspecialchars($recipient['longitude_point']); ?>" required><br>
        Latitude: <input type="text" name="latitude_point" value="<?php echo htmlspecialchars($recipient['latitude_point']); ?>" required><br>
        <input type="submit" value="Update Recipient">
    </form>
</body>
</html>