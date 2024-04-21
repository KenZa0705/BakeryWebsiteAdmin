<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo San Bakery</title>
    <link rel="stylesheet" href="trystyles.css">
</head>

<body>
    <div id="admin-dashboard">


        <h2> </h2> <!-- title for 2nd tab -->

        <ul class="tabs">
            <li><a onclick="openTab('Dashboard')">Dashboard</a></li>
            <li><a onclick="openTab('Admin-info')">Inventory</a></li>
            <li><a onclick="openTab('sales-expenses')">Sales</a></li>
            <li><a onclick="openTab('order-info')">Order Info</a></li>
        </ul>

        <div id="Dashboard" class="tab-content active-tab">
            <!-- Content for Stocks tab -->
            <h3>Dashboard</h3>

            <div class="metrics-container">
                <div class="metric">
                    <h2>Total Products</h2>
                    <?php require_once 'includes/totalproducts.php'; ?>
                </div>
                <div class="metric">
                    <h2>Low Stock Products</h2>
                    <?php require_once 'includes/lowstockproducts.php'; ?>
                </div>
                <div class="metric">
                    <h2>Out of Stock Products</h2>
                    <?php require_once 'includes/outofstock.php'; ?>
                </div>
            </div>

            <h3>Recent Sales</h3>
            <?php
            require_once 'includes/recentorders.php';
            ?>
        </div>
    </div>
    </div>


    <div id="Admin-info" class="tab-content">
        <!-- Content for Customer Info tab -->
        <h3>Inventory</h3>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search...">
            <button onclick="search()" id="searchButton">Search</button>
        </div>

        <div id="searchResults">
            <!-- Search results will be displayed here -->
        </div>
        <div class="inventory-container">

            <div id="inventoryList">
                <!-- Inventory items will be displayed here -->
            </div>
            <button onclick="addProduct()">Add Product</button>
        </div>

        <div id="productModal" class="modal" style="display: none;">
            <form id="productForm" method="post" action="includes/addproduct.inc.php">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Add Product</h2>
                    <input type="text" id="Name" name="Name" placeholder="Name">
                    <input type="text" id="Description" name="Description" placeholder="Description">
                    <input type="text" id="Price" name="Price" placeholder="Price">
                    <input type="text" id="Quantity" name="Quantity" placeholder="Quantity">
                    <button id="saveButton" type="submit">Save</button>
                </div>
            </form>
        </div>
        <?php
        require_once 'includes/products.php';
        ?>
    </div>

    <div id="sales-expenses" class="tab-content">
        <!-- Content for Sales & Expenses tab -->
        <h3>Sales</h3>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1001</td>
                    <td>101</td>
                    <td>2024-02-28</td>
                    <td>25.00</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <div id="order-info" class="tab-content">
        <!-- Content for Order Info tab -->
        <h3>Order Information</h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2001</td>
                    <td>101</td>
                    <td>1</td>
                    <td>5</td>
                    <td>25.00</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    </div>



    <script src="script.js"></script>

</body>

</html>
<?php
require_once 'includes/dbh.inc.php';
?>