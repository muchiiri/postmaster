<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Parcel</title>
</head>
<body>
    <h2>Create Parcel</h2>
    <form action="../../controllers/ParcelController.php" method="post">
    <input type="hidden" name="operation" value="create">
        Delivery User: 
        <select name="delivery_user">
            <option value=""></option>
            <?php
            // Fetch users with the role of delivery user from the database
            $pdo = new PDO('mysql:host=localhost;dbname=parcelbuddy', 'root', '');
            $stmt = $pdo->prepare('SELECT username FROM users WHERE user_type = "delivery_user"');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output each user as an option in the dropdown
            foreach ($users as $user) {
                echo '<option value="' . $user['username'] . '">' . $user['username'] . '</option>';
            }
            ?>
        </select>
        <br>
        Recipient:
        <select name="recipient">
            <option value=""></option>
            <?php
            // Fetch recipients from the database
            $stmt = $pdo->prepare('SELECT point_id, recipient_name FROM recipients');
            $stmt->execute();
            $recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output each recipient as an option in the dropdown
            foreach ($recipients as $recipient) {
                echo '<option value="' . $recipient['point_id'] . '">' . $recipient['recipient_name'] . '</option>';
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Create Parcel">
    </form>

    <!-- Links for listing users and recipients -->
    <p><a href="../../views/users/list.php">List Delivery Users</a></p>
    <p><a href="../../views/recipients/list.php">List Recipients</a></p>
    <p><a href="../../views/parcels/list.php">List Parcels</a></p>
</body>
</html>
