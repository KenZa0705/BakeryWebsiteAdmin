<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    // If not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

// Retrieve user's information from session
$user = $_SESSION['admin'];
$admin_id = $_SESSION['admin']['admin_id'];
$position = $_SESSION['admin']['position'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo San Bakery</title>
    <link rel="stylesheet" href="trystyles.css">
</head>

<body>
    <div id="admin-dashboard" class="dashboard-container">
        <a onclick="openTab('Dashboard')"><img src="images/main logo.png" alt="Main Logo"></a>
        <ul class="tabs">

            <li><a onclick="openTab('Dashboard')">Dashboard</a></li>
            <li><a onclick="openTab('Inventory')">Inventory</a></li>
            <?php if ($position === 'Manager') : ?>
                <li><a onclick="openTab('sales-expenses')">Sales</a></li>
                <li><a onclick="openTab('customer-info')">Customer Info</a></li>
            <?php endif; ?>
            <li><a onclick="openTab('orderoperations')">Order Operations</a></li>
            <li><a onclick="return logout()">Logout</a></li>
        </ul>

        <div id="Dashboard" class="tab-content active-tab">
            <!-- Content for Stocks tab -->
            <h3 class="dashboard-title">Dashboard</h3>

            <div class="metrics-container">
                <div class="metric">
                    <h2>Total Products</h2>
                    <p class="num"><?php require_once 'includes/totalproducts.php'; ?></p>
                </div>
                <div class="metric">
                    <h2>Low Stock Products</h2>
                    <p class="num"><?php require_once 'includes/lowstockproducts.php'; ?></p>
                </div>
                <div class="metric">
                    <h2>Out of Stock Products</h2>
                    <p class="num"><?php require_once 'includes/outofstock.php'; ?></p>
                </div>
            </div>
            <a href="#recentSales">
                <h3 id="recentSales">Recent Sales</h3>
            </a>
            <?php
            require_once 'includes/recentorders.php';
            require_once 'includes/bestseller.inc.php';
            ?>
        </div>
    </div>


    <div id="Inventory" class="tab-content">
        <h3 class="inventory-title">Inventory</h3>
        <div class="search-container">
            <form action="includes/search.inc.php" method="POST">
                <input type="text" id="searchInput" name="searchInput" class="search-input" placeholder="Search...">
                <button type="submit" id="searchButton" class="search-button">Search</button>
            </form>
        </div>
        <div id="searchResults">
            <!-- Search results will be displayed here -->

        </div>
        <div id="productModal" class="modal" style="display: none;">
            <form id="productForm" method="post" action="includes/addproduct.inc.php">
                <div class="modal-content">
                    <span class="close" onclick="closeBox('productModal')">&times;</span>
                    <h2 id="modalTitle" class="modal-title">Add Product</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <input type="text" id="Name" name="Name" placeholder="Name" class="modal-input">
                    <input type="text" id="Description" name="Description" placeholder="Description"
                        class="modal-input">
                    <input type="text" id="Price" name="Price" placeholder="Price" class="modal-input">
                    <input type="text" id="Quantity" name="Quantity" placeholder="Quantity" class="modal-input">
                    <input type="text" id="Expense" name="Expense" placeholder="Expense" class="modal-input">
                    <input type="text" id="Supplied" name="Supplier" placeholder="Supplier ID" class="modal-input">
                    <button id="saveButton" type="submit" class="modal-button">Save</button>
                </div>
            </form>
        </div>
        <div class="inventory-container">
            <div id="inventoryList">
                <!-- Inventory items will be displayed here -->
                <button onclick="openBox('productModal')" class="invButtons">Add Product</button>
                <?php
                require_once 'includes/products.php';
                ?>
            </div>
        </div>
    
    </div>

    <div id="sales-expenses" class="tab-content">
        <!-- Content for Sales & Expenses tab -->
            <h3 class="sales-title">Sales</h3>
            <div class="metrics-container">

                <div class="metric">
                    <h2>Most Sold Product</h2>
                    <p><?php require_once 'includes/mostsoldproduct.php'; ?></p>

                </div>
                <div class="metric">
                    <h2>Least Sold Products</h2>
                    <p><?php require_once 'includes/leastsoldproduct.php'; ?></p>
                </div>
                <div class="metric">
                    <h2>Total Expenses</h2>
                    <p><?php require_once 'includes/totalexpenses.php'; ?></p>
                </div>
                <div class="metric">
                    <h2>Total Profit</h2>
                    <p><?php require_once 'includes/totalprofit.php'; ?></p>
                </div>
                <div class="metric">
                    <h2>Total Sales</h2>
                    <p class="num"><?php require_once 'includes/totalsalesamount.php'; ?></p>
                </div>
            </div>

        <?php
        require_once 'includes/sales.inc.php';
        ?>
    </div>

    <div id="customer-info" class="tab-content">
        <!-- Content for Customer Info tab -->
        <h3 class="customer-title">Customer Information</h3>
        <?php
        require_once 'includes/customers.inc.php';
        ?>
    </div>
    <div id="orderoperations" class="tab-content">
        <!-- Content for Customer Info tab -->
        <h3 class="orderoperations-title">Order Operations</h3>
        <?php
        require_once 'includes/orderoperations.php';
        ?>
    </div>
    
    <script src="script.js"></script>

</body>

</html>
<?php
require_once 'includes/dbh.inc.php';

?>