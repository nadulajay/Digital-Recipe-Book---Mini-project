<?php


$host = 'localhost';
$dbname = 'recipe_book';
$username = 'root';
$password = ''; // Default XAMPP / WAMP password is empty

try {
    // Create PDO connection instance
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    // Die cleanly with diagnostic message if database fails to connect
    die("Database Connection Error: " . $e->getMessage());
}
?>