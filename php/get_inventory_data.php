<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch inventory data from your database
$sql = "SELECT p.product_name, s.stocks_qnt AS quantity_available FROM products p
        INNER JOIN in_stocks s ON p.product_id = s.product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Store retrieved data in an array
    $inventoryData = array();
    while ($row = $result->fetch_assoc()) {
        $inventoryData[] = array(
            "product_name" => $row["product_name"],
            "quantity_available" => $row["quantity_available"]
        );
    }

    // Send JSON response with inventory data
    header('Content-Type: application/json');
    echo json_encode($inventoryData);
} else {
    echo "No inventory data found";
}

$conn->close();
?>
