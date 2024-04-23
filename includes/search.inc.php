<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../trystyles.css">
    <title>Document</title>
</head>

<body>
    <div id="searchModal" class="modal" style="display:block;">
        <div class="modal-content">
            <table>
            <span class="close" onclick="window.location.href='../mainInterface.php#Inventory';">&times;</span>
                <tr>
                    <th> </th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Available Stocks</th>
                </tr>
            
            <?php

            require_once 'dbh.inc.php';

            try {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $value = $_POST['searchInput'];

                    // Check if the input contains only digits to determine if it's an integer
                    if (ctype_digit($value)) {
                        $query = "SELECT product_id, name, description, price, quantity_available FROM products WHERE product_id = :searchInput;";
                    } else {
                        // Lowercase the input for case-insensitive searching
                        $value = strtolower($value);
                        $query = "SELECT product_id, name, description, price, quantity_available FROM products WHERE LOWER(name) LIKE :searchInput;";
                        $value = "%$value%"; // Add wildcards for LIKE operator
                    }

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':searchInput', $value);
                    $stmt->execute();
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($products as $product) {
                        echo "
                        <tr>
                            <td>{$product['product_id']}</td>
                            <td>{$product['name']}</td>
                            <td>{$product['description']}</td>
                            <td>{$product['price']}</td>
                            <td>{$product['quantity_available']}</td>
                        </tr>";
                    }
                } else {
                    // Redirect if the request method is not POST
                    header('Location: ../mainInterface.php');
                    exit; // Exit to prevent further execution
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            ?>
            </table>

        </div>
    </div>
    <script src="../script.js"></script>
</body>

</html>