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

// Fetch product information from the database with available quantities
$sql = "SELECT p.product_id, p.product_name, p.description, p.price, s.stocks_qnt AS quantity_available
        FROM products p
        inner JOIN in_stocks s ON p.product_id = s.product_id";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Return product information as JSON
header('Content-Type: application/json');
echo json_encode($products);

// Close the database connection
$conn->close();
?>
