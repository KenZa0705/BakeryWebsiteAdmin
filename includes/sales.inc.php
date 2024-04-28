<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../trystyles.css">
    <title>Document</title>
</head>

<body>
    <form id="sortForm" class="sortForm">
        <label for="sortColumn">Sort by:</label>
        <select name="sortColumn" id="sortColumn">
            <option value="order_number">Order Number</option>
            <option value="customer">Customer</option>
        </select>

        <label for="sortOrder">Order:</label>
        <select name="sortOrder" id="sortOrder">
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>

        <button type="button" onclick="sortTable()">Sort</button>
    </form>
    <div class="sales-table-container">
        <table id="orderTable">
            <thead>
                <tr class='order_table'>
                    <th class='order_head'>Order Number</th>
                    <th class='order_head'>Customer</th>
                    <th class='order_head'>Order Date</th>
                    <th class='order_head'>Total Amount</th>
                    <th class='order_head'>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'dbh.inc.php';

                // Check if sorting parameters are set
                $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 'order_date';
                $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'DESC';

                try {
                    $query = "SELECT orders.order_id, customers.first_name || ' ' || customers.last_name AS Customer, 
                                        orders.order_date, orders.total_price, orders.status
                                        FROM orders 
                                        INNER JOIN customers ON orders.customer_id = customers.customer_id
                                        ORDER BY $sortColumn $sortOrder";
                    $recent_products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($recent_products as $row) {
                        echo "
                                    <tr>
                                        <td>{$row['order_id']}</td>
                                        <td>{$row['customer']}</td>
                                        <td>{$row['order_date']}</td>
                                        <td>{$row['total_price']}</td>
                                        <td>{$row['status']}</td>
                                    </tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                ?>
            </tbody>
        </table>
    </div>

    <script>
        function sortTable() {
            var table = document.getElementById("orderTable");
            var rows = table.rows;
            var switching = true;
            var sortColumnIndex = document.getElementById("sortColumn").selectedIndex;
            var sortOrder = document.getElementById("sortOrder").value;

            while (switching) {
                switching = false;
                for (var i = 1; i < rows.length - 1; i++) {
                    var x = rows[i].getElementsByTagName("TD")[sortColumnIndex];
                    var y = rows[i + 1].getElementsByTagName("TD")[sortColumnIndex];
                    var xValue = isNaN(parseFloat(x.innerHTML)) ? x.innerHTML.toLowerCase() : parseFloat(x.innerHTML);
                    var yValue = isNaN(parseFloat(y.innerHTML)) ? y.innerHTML.toLowerCase() : parseFloat(y.innerHTML);

                    if ((sortOrder === 'ASC' && xValue > yValue) || (sortOrder === 'DESC' && xValue < yValue)) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>

</html>