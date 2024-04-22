<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParcelBuddy - Login</title>
</head>
<body>
    <h1>Login to ParcelBuddy</h1>
    <form method="post" action="./controllers/AuthController.php"> <!-- Adjust the action path as needed -->
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <input type="submit" value="Login" />
    </form>

    <a href="views/users/create.php">Register New User</a>
</body>
</html>
