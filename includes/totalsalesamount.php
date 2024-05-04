<?php
require_once 'includes/dbh.inc.php';

try {
    $query = "SELECT SUM(o.total_price) AS count
    FROM order_details od
    JOIN products p ON od.product_id = p.product_id
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.status = 'Picked Up';";
    $totalProducts = $pdo->query($query);
    
    $result = $totalProducts->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $count = $result['count'];
        echo "$count PHP";
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
