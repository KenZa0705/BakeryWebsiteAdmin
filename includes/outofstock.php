<?php
require_once 'includes/dbh.inc.php';

try {
    $query = 'SELECT COUNT(DISTINCT product_id) AS count FROM products WHERE quantity_available = 0;';
    $totalProducts = $pdo->query($query);
    $result = $totalProducts->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $count = $result['count'];
        echo "$count";
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
