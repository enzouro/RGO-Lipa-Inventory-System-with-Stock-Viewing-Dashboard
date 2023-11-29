<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for the dashboard
$sqlTotalProducts = "SELECT COUNT(*) as total FROM products";
$sqlTotalInTransactions = "SELECT COUNT(*) AS totalIn FROM instocks_details";
$sqlTotalOutTransactions = "SELECT COUNT(*) AS totalOut FROM outstocks_details";
$sqlOutOfStock = "SELECT COUNT(*) as total FROM in_stocks WHERE stocks_qnt = 0";

$resultProducts = $conn->query($sqlTotalProducts);
$resultTotalIn = $conn->query($sqlTotalInTransactions);
$resultTotalOut = $conn->query($sqlTotalOutTransactions);
$resultOutOfStock = $conn->query($sqlOutOfStock);

$totalProducts = $totalIn = $totalOut = $outOfStockProducts = 0;

if ($resultProducts->num_rows > 0) {
    $rowTotalProducts = $resultProducts->fetch_assoc();
    $totalProducts = $rowTotalProducts['total'];
}

if ($resultTotalIn->num_rows > 0) {
    $rowTotalIn = $resultTotalIn->fetch_assoc();
    $totalIn = $rowTotalIn['totalIn'];
}

if ($resultTotalOut->num_rows > 0) {
    $rowTotalOut = $resultTotalOut->fetch_assoc();
    $totalOut = $rowTotalOut['totalOut'];
}

if ($resultOutOfStock->num_rows > 0) {
    $rowOutOfStock = $resultOutOfStock->fetch_assoc();
    $outOfStockProducts = $rowOutOfStock['total'];
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <!-- Include CSS -->
    <link rel="stylesheet" href="./css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/admin.js"></script>
    
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <img class="logo" src="images/rgoLogo.jpg"></img>
            <h3 class="h3"><i class="fas fa-user-tie"></i> ADMIN</h3>
        </div>
        <div class="list-unstyled components">
            <button class="sidebar-btn active" id="btnDashboard">
            <i class="fas fa-chart-line"></i>Dashboard 
            </button>
            <button class="sidebar-btn" id="btnProducts">
            <i class="fas fa-box"></i>Products 
            </button>
            <button class="sidebar-btn" id="btnTransactions">
            <i class="fas fa-money-bill-wave"></i>Transactions 
            </button>
            <button class="sidebar-btn" id="btnUserAccounts">
            <i class="fas fa-users"></i>User Accounts 
            </button>
            <button class="sidebar-btn" id="btnLogout">
            <i class="fas fa-sign-out-alt"></i>Log Out 
            </button>
        </div>
    </nav>


    <!-- Page content -->
    <div id="content">
        <!-- Dashboard Section -->
        <section id="dashboardSection" class="content-section">
            <!-- Dashboard content -->
            <h2>Welcome, Admin!</h2>
            <div class="summary">
                <div class="summary-box" id="totalProductsBox">
                    <h3>Total Products</h3>
                    <h2><?php echo $totalProducts; ?></h2>
                </div>

                <div class="summary-box" id="totalTransactionsBox">
                    <h3>Total Transactions</h3>
                    <h2>IN: <?php echo $totalIn; ?></h2>
                    <h2>OUT: <?php echo $totalOut; ?></h2>

                </div>

                <div class="summary-box" id="outOfStockProductsBox">
                    <h3>Out of Stock</h3>
                    <h2><?php echo $outOfStockProducts; ?></h2>
                </div>
            </div>

            <div class="chart-container">
                <canvas id="inventoryStatusChart" width="400" height="300"></canvas>
            </div>
        </section>

                <!-- Products Section -->
                <section id="productsSection" class="content-section" style="display: none;">
            <!-- Product table -->
            <h2>Product Information</h2>
            <table id="productsTable">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity Available</th>
                        
                    </tr>
                 <div>
                 <button id="refreshProductsButton">
                      Refresh <i class="fas fa-sync-alt"></i>
                </button>
                    <div>
                    <button id="addProductButton"><i class="fa fa-plus fa-sm"></i></button>
                    <input type="text" id="searchInput" placeholder="Search products">
                    </div>
                 </div>  
                </thead>
                <tbody>
                
                    <!-- Product data will be dynamically loaded here -->
                </tbody>
            </table>
            <h2>Out of Stock</h2>
                <table id="outOfStockTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Out of Stock product data will be dynamically loaded here -->
                    </tbody>
                </table>
        </section>
        <section id="transactionsSection" class="content-section" style="display: none;">
    <!-- Transaction table -->
            <h2>Transaction Information</h2>
            <h3>Product In Transactions</h3>
            <table id="transactionsTableIn">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Added Quantity</th>
                        <th>Recieved Date</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Transaction data will be dynamically loaded here -->
                </tbody>
            </table>

            <h3>Product OUT Transactions</h3>
            <table id="transactionsTableOut">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Subtracted Quantity</th>
                        <th>Dispatched Date</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Transaction data will be dynamically loaded here -->
                </tbody>
            </table>
        </section>
        <section id="userAccountsSection" class="content-section" style="display: none;">
            <!-- User Accounts table -->
            <h2>User Accounts</h2>
            <table id="userAccountsTable">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Department</th>
                        <th>Username</th>
                        <th>Role</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- User account data will be dynamically loaded here -->
                </tbody>
            </table>
        </section>
    </div>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
