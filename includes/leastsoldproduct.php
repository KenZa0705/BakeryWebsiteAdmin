<?php
require_once 'includes/dbh.inc.php';

try {
    // Assuming $pdo is defined in dbh.inc.php
    $query = 'SELECT products.name FROM products
    INNER JOIN order_details ON products.product_id = order_details.product_id
    INNER JOIN orders ON order_details.order_id = orders.order_id
    GROUP BY products.name
    ORDER BY COUNT(order_details.quantity) LIMIT 1;';
    $mostsoldprod = $pdo->query($query);
    
    $result = $mostsoldprod->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $name = $result['name'];
        echo "$name";
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
