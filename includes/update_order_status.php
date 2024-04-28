<?php
// Start the script with a secure session and error handling
session_start();
require_once 'dbh.inc.php'; // Include database connection

// Check if the POST parameters are set and valid
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    die("<script>alert('Invalid input. Order ID and status are required.'); window.location.href = document.referrer;</script>");
}

// Get the POST parameters
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Validate the status to ensure it's one of the expected values
$allowed_statuses = ['Processing', 'Ready', 'Picked Up'];
if (!in_array($status, $allowed_statuses)) {
    die("<script>alert('Invalid status value.'); window.location.href = document.referrer;</script>");
}

try {
    // Establish the database connection
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query to update the order status
    $query = "UPDATE orders SET status = :status WHERE order_id = :order_id";
    
    $statement = $pdo->prepare($query);

    // Bind the parameters to the query
    $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_STR);

    // Execute the update
    $statement->execute();

    // Confirmation message in a JavaScript alert with redirect
    echo "<script>alert('Order status updated successfully.'); window.location.href = document.referrer;</script>";

} catch (PDOException $e) {
    // Handle any database errors and redirect
    echo "<script>alert('Error updating order status: " . $e->getMessage() . "'); window.location.href = document.referrer;</script>";
}

?>
