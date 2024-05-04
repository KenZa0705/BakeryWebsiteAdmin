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
        <div class="modal-content" style="display: block;">
            <table>
            <span class="close" onclick="history.back()">&times;</span>
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

                    //check if number
                    if (ctype_digit($value)) {
                        $query = "SELECT product_id, name, description, price, quantity_available FROM products WHERE product_id = :searchInput;";
                    } else {
                        //strings
                        $value = strtolower($value);
                        $query = "SELECT product_id, name, description, price, quantity_available FROM products WHERE LOWER(name) LIKE :searchInput;";
                        $value = "%$value%";
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
                    header('Location: ../mainInterface.php');
                    exit;
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