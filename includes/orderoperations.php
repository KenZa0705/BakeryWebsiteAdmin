<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <style>
        #orderoperationstab {
            max-height: 600px; 
            overflow-y: auto; 
            margin-bottom: 100px; 
            border: 5px solid #fff;
        }
    </style>
</head>

<body>
    <form method="GET" action="">
        <label for="status_filter">Filter by Status:</label>
        <select name="status_filter" id="status_filter">
            <option value="">All</option>
            <option value="Processing">Processing</option>
            <option value="Ready">Ready</option>
            <option value="Picked Up">Picked Up</option>
            <option value="Canceled">Canceled</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div id="orderoperationstab">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Date Ordered</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Products</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
            <?php
            require_once 'dbh.inc.php';

            $statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

            try {
                $query = "SELECT 
                            o.order_id,
                            o.customer_id,
                            o.order_date,
                            p.price * od.quantity AS price,
                            od.quantity,
                            p.name AS product_name,
                            o.status
                          FROM 
                            order_details AS od
                          JOIN 
                            orders AS o ON od.order_id = o.order_id
                          JOIN 
                            products AS p ON od.product_id = p.product_id";

                if (!empty($statusFilter)) {
                    $query .= " WHERE o.status = :status_filter";
                }
                $query .= " ORDER BY order_id DESC";
                $stmt = $pdo->prepare($query);

                if (!empty($statusFilter)) {
                    $stmt->bindParam(':status_filter', $statusFilter);
                }

                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($orders as $row) {
                    echo "
                        <tr>
                            <td>{$row['order_id']}</td>
                            <td>{$row['customer_id']}</td>
                            <td>{$row['order_date']}</td>
                            <td>{$row['price']} PHP</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form action='includes/update_order_status.php' method='POST'>
                                    <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                    <select name='status'>
                                        <option value='Processing' " . ($row['status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                                        <option value='Ready' " . ($row['status'] == 'Ready' ? 'selected' : '') . ">Ready</option>
                                        <option value='Picked Up' " . ($row['status'] == 'Picked Up' ? 'selected' : '') . ">Picked Up</option>
                                        <option value='Canceled' " . ($row['status'] == 'Canceled' ? 'selected' : '') . ">Canceled</option>
                                    </select>
                                    <button type='submit'>Update</button>
                                </form>
                            </td>
                        </tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </table>
    </div>
    <script src="../script.js">
    </script>

</body>

</html>