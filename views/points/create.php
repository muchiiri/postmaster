<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Recipient</title>
</head>
<body>
    <h2>Create Recipient</h2>
    <form action="../../controllers/PointController.php" method="post">
    <input type="hidden" name="operation" value="create">
        Name: <input type="text" name="recipient_name" required><br>
        Address: <input type="text" name="recipient_address" required><br>
        Postal Code: <input type="text" name="recipient_postalcode" required><br>
        Longitude: <input type="text" name="longitude_point" required><br>
        Latitude: <input type="text" name="latitude_point" required><br>
        <input type="submit" value="Create Recipient">
    </form>
</body>
</html>
