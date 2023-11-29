<?php
// Establish your database connection 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ba3102";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product information from the database with available quantities based on the search term
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT p.product_id, p.product_name, p.description, p.price, s.stocks_qnt AS quantity_available
                            FROM products p
                            LEFT JOIN in_stocks s ON p.product_id = s.product_id
                            WHERE p.product_name LIKE ?");
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display filtered results in HTML format
        while ($row = $result->fetch_assoc()) {
            $price_with_peso = html_entity_decode('&#8369;', ENT_HTML5, 'UTF-8') . number_format($row["price"], 2);
            ?>
            <tr>
                <td class='px-4 py-2'><?php echo $row["product_id"]; ?></td>
                <td class='px-4 py-2'><?php echo $row["product_name"]; ?></td>
                <td class='px-4 py-2'><?php echo $row["description"]; ?></td>
                <td class=' px-4 py-2'><?php echo $price_with_peso; ?></td>
                <td class=' px-4 py-2'><?php echo $row["quantity_available"]; ?></td>
                <td class=' px-4 py-2 inline-flex'>
                    <!-- Add and Out buttons -->
                </td>
            </tr>
            <?php
        }
    } else {
        echo "No results found";
    }

    $stmt->close();
} else {
    echo "No search term provided";
}

$conn->close();
?>
