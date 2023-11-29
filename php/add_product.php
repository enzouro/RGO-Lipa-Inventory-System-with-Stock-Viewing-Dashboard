<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product details from POST data
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];

    // Get the current maximum product_id
    $maxProductIDQuery = "SELECT MAX(product_id) AS max_id FROM products";
    $result = $conn->query($maxProductIDQuery);
    $row = $result->fetch_assoc();
    $maxID = $row['max_id'];

    // Increment the product_id
    $nextID = $maxID + 1;

    // Prepare the SQL statement with the incremented ID
    $sql = "INSERT INTO products (product_id, product_name, description, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issd", $nextID, $productName, $productDescription, $productPrice);

    if ($stmt->execute()) {
        // Insert the quantity available into in_stocks table
        $sqlQuantity = "INSERT INTO in_stocks (product_id, stocks_qnt) VALUES (?, ?)";
        $stmtQuantity = $conn->prepare($sqlQuantity);
        $stmtQuantity->bind_param("ii", $nextID, $productQuantity);

        if ($stmtQuantity->execute()) {
            // Product and quantity added successfully
            echo json_encode(array("status" => "success", "message" => "Product added successfully"));
        } else {
            // Failed to add quantity
            echo json_encode(array("status" => "error", "message" => "Failed to add product quantity"));
        }

        // Close the quantity statement
        $stmtQuantity->close();
    } else {
        // Failed to add product
        echo json_encode(array("status" => "error", "message" => "Failed to add product"));
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If it's not a POST request
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>