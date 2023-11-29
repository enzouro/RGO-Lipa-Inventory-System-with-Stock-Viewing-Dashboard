<?php
// Establish connection to the database 
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the data from the POST request
    $productName = $_POST["productName"];
    $productDescription = $_POST["productDescription"];
    $productPrice = $_POST["productPrice"];
    $productQuantity = $_POST["productQuantity"];

    // Assuming your database connection variable is $conn
    // Fetch the last/maximum product ID
    $getLastProductIdQuery = "SELECT MAX(product_id) AS max_id FROM products";
    $result = $conn->query($getLastProductIdQuery);
    $row = $result->fetch_assoc();
    $lastProductId = $row["max_id"];

    // Increment the last product ID to assign a new one
    $newProductId = $lastProductId + 1;

    // Insert into products table
    $insertProductQuery = "INSERT INTO products (product_id, product_name, description, price) VALUES ($newProductId, '$productName', '$productDescription', $productPrice)";
    $conn->query($insertProductQuery);

    // Insert into in_stocks table
    $insertStocksQuery = "INSERT INTO in_stocks (product_id, stocks_qnt) VALUES ($newProductId, $productQuantity)";
    $conn->query($insertStocksQuery);

    // Send a success response
    echo json_encode(["success" => true, "message" => "Product added successfully"]);
} else {
    // Send an error response
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
