<?php
session_start();
require_once 'dbh.inc.php';

// User and pass verification
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //checking username
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    //checking if the result match password too
    if ($user && $password === $user['password'] && $user['status'] === 'Active') {
        //store user data in session and redirect
        $_SESSION['admin'] = $user;
        header("Location: ../mainInterface.php");
        exit();
    } else {
        header("Location: ../index.php?error=Incorrect username or password");
        exit();
    }
} else {
    header("Location: ../index.php?error=Username and password are required");
    exit();
}
