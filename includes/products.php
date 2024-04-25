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
        <span class="close" onclick="closeBox('updateModal');">&times;</span>
        <form action="includes/updateproducts.php" method="POST">
            <h2 id="modalTitle" class="modal-title">Update</h2>
            <input type="text" id="product_id" name="product_id" placeholder="Enter Product ID">
            <button type="submit">Update</button>
        </form>
    </div>
</div>
<button onclick="openBox('deleteModal')" class="invButtons">Delete</button>
<div id="deleteModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close" onclick="closeBox('deleteModal')">&times;</span>
        <form action="includes/process_delete.php" method="POST" onsubmit="return confirmDelete()">
            <h2 id="modalTitle" class="modal-title">Delete</h2>
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
            <th>Expense</th>
            <th>Supplier</th>
            <th>Update/Delete</th>
        </tr>
        <?php
        require_once 'dbh.inc.php';

        try {
            $query = "SELECT p.product_id, p.name, p.description, p.price, p.quantity_available, p.expense, s.name AS supplier
            FROM products p
            JOIN suppliers s ON s.supplier_id = p.supplier_id ORDER BY product_id DESC;";
            $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $row) {
                echo "
                <tr>
                    <td>{$row['product_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['quantity_available']}</td>
                    <td>{$row['expense']}</td>
                    <td>{$row['supplier']}</td>
                    <td>
                    <form action='includes/updateproducts.php' method='POST' style='display: inline;'> 
                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                        <button type='submit'><img src='images/Update.png' alt='Update' width=20px></button>
                    </form>
                    <form id='deleteForm' action='includes/process_delete.php' method='POST' style='display: inline;'> 
                        <input type='hidden' name='product_id' value='{$row['product_id']}'>
                        <button type='submit' onclick=\"return confirm('Are you sure you want to delete this product?');\">
                        <img src='images/trash.png' alt='Delete' width='20px'>
                        </button> 
                    </form>
                    </td>
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
