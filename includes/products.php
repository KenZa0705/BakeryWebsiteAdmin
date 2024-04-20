<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<table>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Available Stocks</th>
                    </tr>
                        <?php
                        require_once 'dbh.inc.php';

                        try {
                            $query = "SELECT name, description, price, quantity_available FROM products;";
                            $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($products as $row) {
                                echo "
                                <tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['quantity_available']}</td>
                                </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        
                        ?>
                        </table>
</body>
</html>

