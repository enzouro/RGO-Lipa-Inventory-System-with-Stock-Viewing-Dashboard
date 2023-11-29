<?php
// Database connection details
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

// Fetch Product Out transactions from the database
$sql = "SELECT p.product_id, p.product_name, d.out_qnt AS quantity, d.received_date, d.empid, e.firstname
        FROM products p
        JOIN outstocks_details d ON p.product_id = d.product_id
        JOIN tbempinfo e ON d.empid = e.empid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $transactions = array();
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    // Return transactions data as JSON
    header('Content-Type: application/json');
    echo json_encode($transactions);
} else {
    echo "0 results";
}

$conn->close();
?>
