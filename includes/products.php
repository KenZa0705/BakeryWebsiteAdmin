<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./trystyles.css">
    <title>Document</title>
 
</head>

<body>
<button onclick="openBox('updateModal')" class="invButtons">Update</button>
<div id="updateModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close" onclick="closeBox('updateModal')">&times;</span>
        <form action="includes/updateproducts.php" method="POST">
            <h2 id="modalTitle" class="modal-title">Update</h2>
            <label for="product_id">Product ID:</label>
            <input type="text" id="product_id" name="product_id" placeholder="Enter Product ID">
            <button type="submit">Update</button>
        </form>
    </div>
</div>
<button onclick="openBox('deleteModal')" class="invButtons">Delete</button>
<div id="deleteModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close" onclick="closeBox('deleteModal')">&times;</span>
        <form action="includes/process_delete.php" method="POST">
            <h2 id="modalTitle" class="modal-title">Delete</h2>
            <label for="product_id">Product ID:</label>
            <input type="text" id="product_id" name="product_id" placeholder="Enter Product ID">
            <button type="submit">Delete</button>
        </form>
    </div>
</div>
    <table>
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
            $query = "SELECT product_id, name, description, price, quantity_available FROM products ORDER BY product_id DESC;";
            $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $row) {
                echo "
                <tr>
                    <td>{$row['product_id']}</td>
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

    <script src="./script.js">
    </script>

</body>

</html>
