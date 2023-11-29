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

// Fetch combined data from tbempinfo and rgouser tables
$sql = "SELECT tbempinfo.empid, tbempinfo.lastname, tbempinfo.firstname, tbempinfo.department, rgouser.username, rgouser.role FROM tbempinfo 
        INNER JOIN rgouser ON tbempinfo.empid = rgouser.empid";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $userAccounts = array();
    while ($row = $result->fetch_assoc()) {
        $userAccounts[] = $row;
    }
    echo json_encode($userAccounts);
} else {
    echo "No user accounts found";
}

$conn->close();
?>

