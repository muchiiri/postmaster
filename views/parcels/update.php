<?php
// Start the session and check user authentication
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../../index.php');
    exit;
}

require_once '../../models/DatabaseConnection.php';
require_once '../../models/ParcelModel.php';

$pdoConnection = DatabaseConnection::getPDOConnection();
$parcelModel = new ParcelModel($pdoConnection);

// Get parcel ID from query string
$parcel_id = isset($_GET['parcel_id']) ? $_GET['parcel_id'] : '';

// Fetch parcel data
$parcel = $parcelModel->getParcelById($parcel_id);

// Fetch delivery users
$stmt = $pdoConnection->prepare('SELECT username FROM users WHERE user_type = "delivery_user"');
$stmt->execute();
$deliveryUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch recipients
$stmt = $pdoConnection->prepare('SELECT point_id, recipient_name FROM recipients');
$stmt->execute();
$recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Parcel</title>
</head>
<body>
    <h2>Update Parcel</h2>
    <form action="../../controllers/ParcelController.php" method="post">
        <input type="hidden" name="parcel_id" value="<?php echo htmlspecialchars($parcel['parcel_id']); ?>">
        <input type="hidden" name="operation" value="update">
        Delivery User: 
        <select name="delivery_user">
            <?php foreach ($deliveryUsers as $user): ?>
            <option value="<?php echo htmlspecialchars($user['username']); ?>" <?php if ($user['username'] == $parcel['delivery_user']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($user['username']); ?>
            </option>
            <?php endforeach; ?>
        </select><br>
        
        Recipient:
        <select name="recipient">
            <?php foreach ($recipients as $recipient): ?>
            <option value="<?php echo htmlspecialchars($recipient['point_id']); ?>" <?php if ($recipient['point_id'] == $parcel['recipient_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($recipient['recipient_name']); ?>
            </option>
            <?php endforeach; ?>
        </select><br>
        
        <input type="submit" value="Update Parcel">
    </form>
</body>
</html>