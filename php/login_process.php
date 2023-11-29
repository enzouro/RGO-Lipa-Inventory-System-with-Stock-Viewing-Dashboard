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

// Retrieve user input from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Sanitize user input to prevent SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Check the credentials against the database
$query = "SELECT * FROM `rgouser` WHERE `username`='$username' AND `password`='$password'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $role = $row['role'];
    $response = array("status" => "success", "role" => $role);
    echo json_encode($response);
} else {
    $response = array("status" => "error");
    echo json_encode($response);
}

$conn->close();
?>
