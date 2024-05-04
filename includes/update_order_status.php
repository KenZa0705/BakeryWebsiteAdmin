<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    die("<script>alert('Invalid input. Order ID and status are required.'); window.location.href = document.referrer;</script>");
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

$allowed_statuses = ['Processing', 'Ready', 'Picked Up', 'Canceled'];
if (!in_array($status, $allowed_statuses)) {
    die("<script>alert('Invalid status value.'); window.location.href = document.referrer;</script>");
}

try {
    $pdo->beginTransaction(); // Start

    $query = "UPDATE orders SET status = :status WHERE order_id = :order_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_STR);

    $statement->execute();
    if($status == 'Canceled'){
        $query3 = "SELECT quantity, product_id FROM order_details WHERE order_id = :order_id";
        $stmt3 = $pdo->prepare($query3);
        $stmt3->bindParam(':order_id', $order_id);
        $stmt3->execute();
        $canceled_products = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        foreach ($canceled_products as $row) {
            $query2 = "UPDATE products SET quantity_available = quantity_available + :quantity WHERE product_id = :product_id";
            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(':quantity', $row['quantity']);
            $stmt2->bindParam(':product_id', $row['product_id']);
            $stmt2->execute();
        }
    }

    // Update payment status
    $query2 = "UPDATE payment_details SET payment_status = 'Paid' WHERE order_id = :order_id";
    $statement2 = $pdo->prepare($query2);
    $statement2->bindParam(":order_id", $order_id, PDO::PARAM_INT);
    $statement2->execute();

    $pdo->commit(); // Commit

    echo "<script>alert('Order status updated successfully.'); window.location.href = document.referrer;</script>";

} catch (PDOException $e) {
    $pdo->rollback(); // Rollback
    echo "<script>alert('Error updating order status: " . $e->getMessage() . "'); window.location.href = document.referrer;</script>";
}
?>
