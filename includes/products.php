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
<?php if ($position === 'Manager') : ?>
    <button onclick="openBox('deleteModal')" class="invButtons">Delete</button>            
<?php endif; ?>
<div id="deleteModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close" onclick="closeBox('deleteModal')">&times;</span>
        <form action="includes/process_delete.php" method="POST" onsubmit="return confirmDelete()">
            <h2 id="modalTitle" class="modal-title">Delete</h2>
            <input type="text" id="product_id" name="product_id" placeholder="Enter Product ID">
            <button type="submit"><img src="images/trash.png" alt="Delete Button">Delete</button>
        </form>
    </div>
</div>
<?php
require_once 'dbh.inc.php';

// Determine the sort order (ascending or descending)
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';

// Toggle the sort order for the next click
$nextSortOrder = $sortOrder === 'ASC' ? 'DESC' : 'ASC';

try {
    // Modify the query to sort by available stocks
    $query = "SELECT p.product_id, p.name, p.description, p.price, p.quantity_available, p.expense, s.name AS supplier
              FROM products p
              JOIN suppliers s ON s.supplier_id = p.supplier_id
              ORDER BY p.quantity_available $sortOrder;";
    
    $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<table>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>
            <!-- Sortable header with link to toggle sort order -->
            <a href="?sort=<?php echo $nextSortOrder; ?>">Available Stocks</a>
        </th>
        <th>Expense</th>
        <th>Supplier</th>
        <th>Update/Delete</th>
    </tr>
    <?php foreach ($products as $row): ?>
    <tr>
        <td><?php echo $row['product_id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['quantity_available']; ?></td>
        <td><?php echo $row['expense']; ?></td>
        <td><?php echo $row['supplier']; ?></td>
        <td>
            <form action='includes/updateproducts.php' method='POST' style='display: inline;'> 
                <input type='hidden' name='product_id' value='<?php echo $row['product_id']; ?>'>
                <button type='submit'><img src='images/Update.png' alt='Update' width='20px'></button>
            </form>
            <!-- Only display the delete button if the logged-in user is a manager -->
            <?php if ($position === 'Manager'): ?>
            <form action='includes/process_delete.php' method='POST' style='display: inline;' onsubmit='return confirmDelete()'> 
                <input type='hidden' name='product_id' value='<?php echo $row['product_id']; ?>'>
                <button type='submit'><img src='images/trash.png' alt='delete' width='20px'></button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>



    <script src="./script.js">
    </script>

</body>

</html>
