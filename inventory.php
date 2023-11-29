<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Page</title>
  <link href="css/inventory.css" rel="stylesheet" >
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet"/>
  

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script src="js/employee.js"></script>
  <script src="js/inventory.js"></script>
  <script>
        function filterStocks() {
            var input, filter, table, tbody, tr, tdId, tdName, i, txtValueId, txtValueName;
            input = document.getElementById("filterInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("stocksTable");
            tbody = document.getElementById("stocks-tbody");
            tr = tbody.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                tdId = tr[i].getElementsByTagName("td")[0]; // Product ID column
                tdName = tr[i].getElementsByTagName("td")[1]; // Product Name column

                if (tdId && tdName) {
                    txtValueId = tdId.textContent || tdId.innerText;
                    txtValueName = tdName.textContent || tdName.innerText;

                    // Check if either Product ID or Product Name contains the filter text
                    if (txtValueId.toUpperCase().indexOf(filter) > -1 || txtValueName.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


</head>
<body>
  <div class="container">
      <!-- Sidebar -->
      <nav id="sidebar">
      <div class="flex flex-col items-center justify-center rounded-3xl p-4" id="sidebar-header">
          <img class="h-28 object-cover rounded-full" src="images/rgoLogo.jpg" alt="Logo">
          <h3 class="text-gray-300 text-lg mt-2"> <i class="fas fa-user-tie"></i> Employee</h3>
      </div>
        <div class="list-unstyled components">
          <button class="sidebar-btn" id="btnProducts">
            <i class="fas fa-box"></i>Products
          </button>
          <button class="sidebar-btn" id="btnProductList" onclick="refreshProducts()">
            <i class="fas fa-list"></i>Stocks
          </button>
          <button  onclick="exit()" class="sidebar-btn" id="btnExit">
            <i class="fas fa-sign-out-alt"></i>Exit
          </button>
        </div>
      </nav>

      <!-- Page content -->
      
      <div id="content">
          <section id="productManagementSection">
          <h2>Product Management</h2>
          <div>
            <input type="text" id="searchInput" placeholder="Search by Product ID or Name">
            <button class="searchProduct" onclick="searchProduct()"><i class="fas fa-search"></i>Search</button>
          </div>
          
            <form id="productForm" methond="POST">
            <label for="productId">Product ID:</label>
                  <input type="text" id="productId" name="productId" readonly>
                  <br>
                  <label for="productName">Product Name:</label>
                  <input type="text" id="productName" name="productName" required>
                  <br><br>
                  <label for="productDescription">Description:</label>
                  <textarea type='text' id="productDescription" name="productDescription"></textarea>
                  <br>
                  <label for="productPrice">Price:</label>
                  <input type="number" step="0.01" id="productPrice" name="productPrice" required>
                  <br><br>
                  <label for="productQuantity">Quantity Available:</label>
                  <input type="number" id="productQuantity" name="productQuantity" required>
                  <br><br>
                  <div class="button-group space-x-4">
                      <button type="button"  onclick="addProduct()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                          <i class="fas fa-plus-circle"></i> Add Product
                      </button>
                      <button type="button"  onclick="deleteProduct()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                          <i class="fas fa-trash-alt"></i> Delete Product
                      </button>
                      <button type="button"  onclick="editProduct()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                          <i class="fas fa-edit"></i> Edit Product
                      </button>
                      <button type="button" onclick="clearFields()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                          <i class="fas fa-times-circle"></i> Clear Fields
                      </button>
                  </div>
              </form>
          </section>

          <section id="productListSection" class="section">
    
          </section>
  </div>
  <script>
    function refreshProducts() {
    // Using AJAX to fetch updated data from the server
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // Update the table content with the fetched data
            document.getElementById("productListSection").innerHTML = this.responseText;
        }
    };

    xhr.open("GET", "php/refresh_products.php", true);
    xhr.send();
}

</script>
</body>
</html>

