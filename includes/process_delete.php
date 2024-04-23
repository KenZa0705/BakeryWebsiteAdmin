<?php
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_id = $_POST['product_id'];

    $query = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    header('Location: ../mainInterface.php');
}