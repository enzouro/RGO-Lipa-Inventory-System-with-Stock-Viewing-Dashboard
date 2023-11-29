<?php
// Establish database connection
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

// Fetch transaction data
$sql = "SELECT transaction_id, employee_id, transaction_date, total_cost FROM transactions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $transactions = array();
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode($transactions);
} else {
    echo "No transactions found";
}

$conn->close();
?>
