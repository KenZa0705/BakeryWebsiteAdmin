<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../trystyles.css">

    <title>Document</title>
</head>

<body>
    <div class="customer-table-container"> <!-- Wrap the table inside a div -->
        <table>
            <tr class='order_table'>
                <th class='order_head'>Customer ID</th>
                <th class='order_head'>Customer</th>
                <th class='order_head'>Email</th>
                <th class='order_head'>Address</th>
                <th class='order_head'>Most Bought Product</th>
            </tr>
            <?php
            require_once 'dbh.inc.php';

            try {
                $query = "WITH ranked_products AS (
                    SELECT 
                        c.customer_id AS cus_id, 
                        c.first_name || ' ' || c.last_name AS name, 
                        c.email, 
                        c.address, 
                        p.name AS product_name,
                        COUNT(*) AS purchase_count,
                        ROW_NUMBER() OVER (PARTITION BY c.customer_id ORDER BY COUNT(*) DESC) AS row_num
                    FROM 
                        customers c
                    INNER JOIN 
                        orders o ON o.customer_id = c.customer_id
                    INNER JOIN 
                        order_details od ON o.order_id = od.order_id
                    INNER JOIN 
                        products p ON od.product_id = p.product_id
                    GROUP BY 
                        c.customer_id, c.first_name, c.last_name, c.email, c.address, p.name
                )
                SELECT 
                    cus_id, 
                    name, 
                    email, 
                    address, 
                    product_name
                FROM 
                    ranked_products
                WHERE 
                    row_num = 1
                ORDER BY 
                    cus_id;                
                ";
                $recent_products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

                foreach ($recent_products as $row) {
                    echo "
                                    <tr>
                                        <td>{$row['cus_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['address']}</td>
                                        <td>{$row['product_name']}</td>
                                    </tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            ?>
        </table>
    </div> <!-- Close the div -->
</body>

</html>
