<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    // Check if the product ID exists in the database
    $query = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Product found, display update form
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../trystyles.css">
            <title>Update Product</title>
        </head>
        <body>
                <h2>Update Product Details</h2>
                <form action="process_update.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="<?php echo $product['name']; ?>">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" placeholder="<?php echo $product['description']; ?>">
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" placeholder="<?php echo $product['price']; ?>">
                    <label for="quantity_available">Quantity Available:</label>
                    <input type="text" id="quantity_available" name="quantity_available"
                        placeholder="<?php echo $product['quantity_available']; ?>">
                    <button type="submit">Update</button>
                </form>
        </body>
        </html>
        <?php
    } else {
        // Product not found
        echo "Product with ID $product_id not found.";
    }
}
?>