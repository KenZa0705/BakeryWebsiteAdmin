<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
</head>
<body>
    <!-- Filter form that navigates to a specific tab using a URL hash -->
    <form method="GET" action=""> <!-- The action points to the desired tab -->
        <label for="status_filter">Filter by Status:</label>
        <select name="status_filter" id="status_filter">
            <option value="">All</option> <!-- Option to show all orders -->
            <option value="Processing">Processing</option>
            <option value="Ready">Ready</option>
            <option value="Picked Up">Picked Up</option>
        </select>
        <button type="submit">Filter</button> <!-- Submit the form with the hash -->
    </form>

    <!-- Placeholder for the tab content -->
    <div id="orderoperationstab"> <!-- Tab content where the orders are displayed -->
        <table>
            <tr>
                <th>Customer ID</th>
                <th>Order ID</th>
                <th>Date Ordered</th>
                <th>Price</th>
                <th>Status</th>
                <th>Products</th>
                <th>Quantity</th>
                <th>Update Status</th>
            </tr>
            <?php
            require_once 'dbh.inc.php';

            // Get the status filter from the GET request
            $statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

            try {
                $query = "SELECT 
                            o.customer_id,
                            o.order_id,
                            o.order_date,
                            p.price * od.quantity AS price,
                            o.status,
                            p.name AS product_name,
                            od.quantity
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
                            <td>{$row['customer_id']}</td>
                            <td>{$row['order_id']}</td>
                            <td>{$row['order_date']}</td>
                            <td>{$row['price']} PHP</td>
                            <td>{$row['status']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>
                                <form action='includes/update_order_status.php' method='POST'>
                                    <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                    <select name='status'>
                                        <option value='Processing' ".($row['status'] == 'Processing' ? 'selected' : '').">Processing</option>
                                        <option value='Ready' ".($row['status'] == 'Ready' ? 'selected' : '').">Ready</option>
                                        <option value='Picked Up' ".($row['status'] == 'Picked Up' ? 'selected' : '').">Picked Up</option>
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
</body>
</html>
