<?php
$host = 'localhost';
$port = '5432';
$dbname = 'third_nf';
$user = 'postgres'; // default PostgreSQL user
$password = 'postgres'; // password you set during installation

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
try {
    // Create a PDO instance
    $pdo = new PDO($dsn);
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, handle the error
    die("Connection failed: " . $e->getMessage());
}
?>
