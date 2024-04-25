<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    // Retrieve the current product details from the database
    $query = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);


    // Initialize arrays to store updated values and placeholders
    $update_values = [];
    $placeholders = [];

    // Check each field for updates and build the query accordingly
    if (!empty($_POST['name']) && $_POST['name'] != $product['name']) {
        $update_values[] = 'name = :name';
        $placeholders[':name'] = $_POST['name'];
    }

    if (!empty($_POST['description']) && $_POST['description'] != $product['description']) {
        $update_values[] = 'description = :description';
        $placeholders[':description'] = $_POST['description'];
    }

    if (!empty($_POST['price']) && $_POST['price'] != $product['price']) {
        $update_values[] = 'price = :price';
        $placeholders[':price'] = $_POST['price'];
    }

    if (!empty($_POST['quantity_available']) && $_POST['quantity_available'] != $product['quantity_available']) {
        $update_values[] = 'quantity_available = :quantity_available';
        $placeholders[':quantity_available'] = $_POST['quantity_available'];
    }

    // If there are updates, construct and execute the update query
    if (!empty($update_values)) {
        $update_query = "UPDATE products SET " . implode(', ', $update_values) . " WHERE product_id = :product_id";
        $stmt = $pdo->prepare($update_query);
        $placeholders[':product_id'] = $product_id;
        $stmt->execute($placeholders);
        echo "Product updated successfully.";
        header('Location: ../mainInterface.php');
    } else {
        echo "No changes were made.";
        header('../mainInterface.php');
    }

} else {
    // Redirect to the update form if accessed directly without POST data
    header("Location: update_product.php");
    exit;
}
