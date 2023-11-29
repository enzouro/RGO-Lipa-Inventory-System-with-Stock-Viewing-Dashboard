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

// Check if it's a POST request and the necessary data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['addedQuantity']) && isset($_POST['empid'])) {
    $productId = $_POST['productId'];
    $addedQuantity = $_POST['addedQuantity'];
    $empid = $_POST['empid'];

    // Perform database update based on action (add/subtract)
    $sql = "INSERT INTO instocks_details (product_id, added_qnt, received_date, empid) VALUES ($productId, $addedQuantity, CURDATE(), $empid)";

    if ($conn->query($sql) === TRUE) {
        // Respond to the AJAX request
        echo json_encode(array("status" => "success", "message" => "Details inserted successfully."));
    } else {
        // If there's an error in the SQL query
        echo json_encode(array("status" => "error", "message" => "Error inserting details: " . $conn->error));
    }
} else {
    // If the request is not valid or data is missing
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
}

$conn->close(); // Close the database connection
?>
