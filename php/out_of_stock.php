<?php
// Establish your database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve out of stock products 
$sql = "SELECT product_id, product_name, description, price FROM products WHERE product_id IN (
    SELECT product_id FROM in_stocks WHERE stocks_qnt = 0
)";
$result = $conn->query($sql);

$outOfStockProducts = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $outOfStockProducts[] = $row;
    }
}

// Return out of stock products data in JSON format
header('Content-Type: application/json');
echo json_encode($outOfStockProducts);

$conn->close();
?>
