<?php
class DatabaseConnection {
    private static $dbHost = "localhost";
    private static $dbName = "parcelbuddy";
    private static $dbUsername = "root";
    private static $dbPassword = "";

    public static function getPDOConnection() {
        try {
            $dsn = "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8";
            $pdo = new PDO($dsn, self::$dbUsername, self::$dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }
}
?>
