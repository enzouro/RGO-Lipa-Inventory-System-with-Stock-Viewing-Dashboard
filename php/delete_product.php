<?php
// Establish your database connection 
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

// Establish database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productId"])) {
    $productId = $_POST["productId"];

    // Delete from products table
    $deleteProductQuery = "DELETE FROM products WHERE product_id = $productId";
    $resultProduct = $conn->query($deleteProductQuery);

    if ($resultProduct) {
        // Return success response
        echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    } else {
        // Return failure response
        echo json_encode(["success" => false, "message" => "Failed to delete product"]);
    }
} else {
    // Return invalid request response if POST data is not received
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>

