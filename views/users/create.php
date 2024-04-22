<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
</head>
<body>
    <h2>Register User</h2>
    <form action="../../controllers/UserController.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        User Type: 
        <select name="user_type">
            <option value="admin">Admin</option>
            <option value="delivery_user">Delivery User</option>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
