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

// Fetch product information from the database with available quantities
$sql = "SELECT p.product_id, p.product_name, p.description, p.price, s.stocks_qnt AS quantity_available
        FROM products p
        LEFT JOIN in_stocks s ON p.product_id = s.product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>src="js/inventory.js"</script>
    <script>src="js/employee.js"</script>
</head>
<div class='bg-gradient-to-r from-red-200 to-red-400 rounded-lg'>
   
    <div class='flex justify-between items-center px-4 py-2'>
    <h2 class='text-xl font-bold'>STOCKS</h2>
        <button id='refreshProductsButton' onclick='refreshProducts()' class='text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center'>
            Refresh <i class='fas fa-sync-alt ml-2'></i>
        </button>
    </div>
    <div class="px-4 py-2">
        <input type="text" id="filterInput" placeholder="Search by ID or Name" class="rounded-lg">
        <button onclick="filterStocks()" class='ml-2 px-4 py-2 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm'>
            Search
        </button>
    </div>
    <div>
        <table class='table-auto border-collapse mx-auto text-xl rounded' id="stocksTable">
            <thead>
                <tr>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm rounded-tl-lg'>Product ID</th>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm'>Product Name</th>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm'>Description</th>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm'>Price</th>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm'>Quantity Available</th>
                    <th class='px-4 py-2 bg-red-400 text-gray-900 uppercase font-semibold text-sm rounded-tr-lg'>Action</th>
                </tr>
                
            </thead>
            <tbody id="stocks-tbody">
                <?php
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
                        <button onclick="confirmUpdate('add', <?php echo $row['product_id']; ?>, <?php echo $row['quantity_available']; ?>)" class='items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent-500 border border-red-900 rounded-s-lg hover:bg-red-700 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700' data-productId='<?php echo $row['product_id']; ?>' data-action='add'>Add</button>

                        <button onclick="confirmUpdate('subtract', <?php echo $row['product_id']; ?>, <?php echo $row['quantity_available']; ?>)" class='items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent-500 border-t border-b border-r border-red-900 rounded-e-lg hover:bg-red-700 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700' data-productId='<?php echo $row['product_id']; ?>' data-action='subtract'>Out</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</html>
<?php
} else {
    echo "0 results";
}
$conn->close();
?>
