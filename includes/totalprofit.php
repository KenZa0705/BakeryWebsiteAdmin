<?php
require_once 'includes/dbh.inc.php';

try {
    // Assuming $pdo is defined in dbh.inc.php
    $query = 'SELECT SUM(o.total_price) - SUM(od.quantity * p.expense) AS total_profit
    FROM order_details od
    JOIN products p ON od.product_id = p.product_id
    JOIN orders o ON od.order_id = o.order_id;';
    $total_profit = $pdo->query($query);
    
    $result = $total_profit->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $count = $result['total_profit'];
        echo "$count PHP";
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
