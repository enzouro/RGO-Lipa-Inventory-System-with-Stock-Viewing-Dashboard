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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['quantity']) && isset($_POST['action'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $action = $_POST['action'];

    // Perform database update based on action (add/subtract)
    if ($action === 'add') {
        $sql = "UPDATE in_stocks SET stocks_qnt = stocks_qnt + $quantity WHERE product_id = $productId";
    } elseif ($action === 'subtract') {
        $sql = "UPDATE in_stocks SET stocks_qnt = stocks_qnt - $quantity WHERE product_id = $productId";
    }

    if ($conn->query($sql) === TRUE) {
        // Respond to the AJAX request 
        http_response_code(200);
        echo json_encode(array("message" => "Quantity updated successfully."));
    } else {
        // If there's an error in the SQL query
        http_response_code(500);
        echo json_encode(array("message" => "Error updating quantity: " . $conn->error));
    }
} else {
    // If the request is not valid or data is missing
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request."));
}

$conn->close(); // Close the database connection
?>
