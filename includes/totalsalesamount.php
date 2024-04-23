<?php
require_once 'includes/dbh.inc.php';

try {
    // Assuming $pdo is defined in dbh.inc.php
    $query = 'SELECT SUM(total_price) AS count FROM orders;';
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
