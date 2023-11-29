<?php
// Establish your database connection here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the search value from the AJAX request
$searchValue = $_GET['search'] ?? '';

// Prepare the query to search by Product ID or Product Name and fetch the quantity available
$query = "SELECT p.*, s.stocks_qnt 
          FROM products p 
          LEFT JOIN in_stocks s ON p.product_id = s.product_id 
          WHERE p.product_id = ? OR p.product_name LIKE ?";
// Prepare the statement
$stmt = $mysqli->prepare($query);

if ($stmt) {
    // Bind the parameters and execute the statement
    $searchParam = "%$searchValue%";
    $stmt->bind_param("is", $searchValue, $searchParam);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $products = array();
    while ($row = $result->fetch_assoc()) {
        $product = array(
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'stocks_qnt' => $row['stocks_qnt'] // Include quantity available field
        );
        $products[] = $product;
    }

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    // Handle the case where the statement preparation fails
    echo "Error in preparing SQL statement: " . $mysqli->error;
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();
?>
