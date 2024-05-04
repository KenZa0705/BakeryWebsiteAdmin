<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["Name"];
    $description = $_POST["Description"];
    $price = $_POST["Price"];
    $quantity = $_POST["Quantity"];
    $expense = $_POST["Expense"];
    $supplier = $_POST["Supplier"];

    try {
        $pdo->beginTransaction(); // Start 
        $query = "INSERT INTO products (name, description, price, quantity_available, expense, supplier_id) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $description, $price, $quantity, $expense, $supplier]);
        $pdo->commit(); // Commit
        header("Location: ../mainInterface.php");
        exit();

    } catch (PDOException $e) {
        $pdo->rollback(); // Rollback
        error_log('Query Failed: ' . $e->getMessage(), 0);
        header("Location: ../mainInterface.php?error=query_failed&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
