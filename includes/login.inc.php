<?php
session_start();
require_once 'dbh.inc.php';

// Check if username and password are provided
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if username exists
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password'] && $user['status'] === 'Active') {
        // User authenticated, redirect to dashboard
        $_SESSION['admin'] = $user;
        header("Location: ../mainInterface.php");
        exit();
    } else {
        // User not found or incorrect password, redirect back to login page with error message
        header("Location: ../index.php?error=Incorrect username or password");
        exit();
    }
} else {
    // Redirect back to login page if username or password is not provided
    header("Location: ../index.php?error=Username and password are required");
    exit();
}
