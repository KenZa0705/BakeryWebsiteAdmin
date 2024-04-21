<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="trystyles.css">
    <title>Document</title>
</head>
<body>
<table>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                    </tr>
                        <?php
                        require_once 'dbh.inc.php';

                        try {
                            $query = "SELECT orders.order_number, customers.first_name || ' ' || customers.last_name AS Customer, 
                                        orders.order_date, orders.delivery_date, orders.total_price, orders.status
                                        FROM orders 
                                        INNER JOIN customers ON orders.customer_id = customers.customer_id
                                        ORDER BY orders.order_date DESC LIMIT 5";
                            $recent_products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($recent_products as $row) {
                                echo "
                                <tr>
                                    <td>{$row['order_number']}</td>
                                    <td>{$row['customer']}</td>
                                    <td>{$row['order_date']}</td>
                                    <td>{$row['delivery_date']}</td>
                                    <td>{$row['total_price']}</td>
                                    <td>{$row['status']}</td>
                                </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        
                        ?>
                        </table>
</body>
</html>

