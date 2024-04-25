<?php
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_id = $_POST['product_id'];

    // Check if product_id exists
    $check_query = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->bindParam(':product_id', $product_id);
    $check_stmt->execute();
    $count = $check_stmt->fetchColumn();

    if ($count > 0) {
        // Product exists, proceed with deletion
        $query = "DELETE FROM products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        header('Location: ../mainInterface.php');
    } else {
        // Product doesn't exist, print error message
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="../trystyles.css">
            <title>Product Not Found</title>
        </head>
        <body>
            <script>
                alert('Product with ID <?php echo $product_id; ?> not found!');
                history.back();
            </script>
        </body>
        </html>
        <?php
    }
}
?>
