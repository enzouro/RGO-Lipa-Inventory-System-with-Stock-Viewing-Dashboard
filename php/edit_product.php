<?php

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

// Retrieve data sent from the JavaScript AJAX call
$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$productId = $data['productId'];
$productName = $data['productName'];
$productDescription = $data['productDescription'];
$productPrice = $data['productPrice'];
$productQuantity = $data['productQuantity'];

// Validate and sanitize inputs (perform validation as needed)

// Update product details in 'products' table
$sql = "UPDATE `products` SET 
        `product_name` = '$productName',
        `description` = '$productDescription',
        `price` = '$productPrice'
        WHERE `product_id` = '$productId'";

if ($conn->query($sql) === TRUE) {
    // Additional logic for updating 'in_stocks' table if needed
    // For instance, updating the quantity
    $updateStocksQuery = "UPDATE `in_stocks` SET `stocks_qnt` = '$productQuantity' WHERE `product_id` = '$productId'";
    $conn->query($updateStocksQuery);

    // Return success message
    $response = array("success" => true);
    echo json_encode($response);
} else {
    // Return error message
    $response = array("success" => false);
    echo json_encode($response);
}

// Close the connection
$conn->close();
?>
