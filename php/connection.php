<?php
$servername = "localhost";
$username = "lorenzo";
$password = "";
$dbname = "db_ba3102";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
