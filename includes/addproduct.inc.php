<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = $_POST["Name"];
    $description = $_POST["Description"];
    $price = $_POST["Price"];
    $quantity = $_POST["Quantity"];
    $expense = $_POST["Expense"];
    $supplier = $_POST["Supplier"];

    try {
        // Prepare SQL statement
        $query = "INSERT INTO products (name, description, price, quantity_available, expense, supplier_id) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);

        // Execute SQL statement
        $stmt->execute([$name, $description, $price, $quantity, $expense, $supplier]);

        // Redirect after successful insertion
        header("Location: ../mainInterface.php");
        exit();
    } catch (PDOException $e) {
        // Log error
        error_log('Query Failed: ' . $e->getMessage(), 0);

        // Redirect with error message
        header("Location: ../mainInterface.php?error=query_failed&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect if not a POST request
    header("Location: ../index.php");
    exit();
}
?>
