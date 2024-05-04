<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./trystyles.css">
    <title>Document</title>
</head>
<!-- Get table data for best sellers shows on dashboard -->
<body>
    <a href="#bestSellers">
    <h3 id="bestSellers">Best Sellers</h3></a>
    <table>
        <tr>
            <th>Name</th>
            <th>Product Number</th>
            <th>Available Stocks</th>
            <th>Price</th>
            <th>Total Number Sold</th>
        </tr>
        <?php
        require_once 'dbh.inc.php';

        try {
            $query = "SELECT products.name, products.product_id,products.quantity_available, products.price, SUM(order_details.quantity) as total_sold
                            FROM order_details
                            JOIN orders ON orders.order_id = order_details.order_id
                            JOIN products ON products.product_id = order_details.product_id
                            GROUP BY products.product_id, products.price, products.name
                            ORDER BY COUNT(order_details.quantity) desc LIMIT 5;
                            ";
            $recent_products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($recent_products as $row) {
                echo "
                    <tr>
                        <td>{$row['name']}</td>
                        <td>{$row['product_id']}</td>
                        <td>{$row['quantity_available']}</td>
                        <td>{$row['price']} PHP </td>
                        <td>{$row['total_sold']}</td>
                    </tr>";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        ?>
    </table>
</body>

</html>