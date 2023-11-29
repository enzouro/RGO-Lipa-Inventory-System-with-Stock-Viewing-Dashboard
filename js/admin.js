$(document).ready(function() {
    // Load default content (Dashboard) when the page loads
    $('#dashboardSection').show();
    $('#productsSection, #transactionsSection, #userAccountsSection').hide();

    // Click event for Dashboard button
    $('#btnDashboard').click(function() {
        $('#dashboardSection').show();
        $('#productsSection, #transactionsSection, #userAccountsSection').hide();
    });

    // Click event for Products button
    $('#btnProducts').click(function() {
        $('#productsSection').show();
        $('#dashboardSection, #transactionsSection, #userAccountsSection').hide();
        // AJAX request to load products
        $.ajax({
            url: 'php/get_products.php', // Replace with your PHP file to fetch products
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Clear previous content in the table
                $('#productsTable tbody').empty();
        
                // Iterate through each product and append to the table
                $.each(response, function(index, product) {
                    $('#productsTable tbody').append(`
                        <tr>
                            <td>${product.product_id}</td>
                            <td>${product.product_name}</td>
                            <td>${product.description}</td>
                            <td>₱${product.price}</td>
                            <td>${product.quantity_available}</td>
                            <!-- Add more columns if needed -->
                        </tr>
                    `);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }

        });
        
    }); 

    // Click event for Transactions button
    $('#btnTransactions').click(function() {
        $('#transactionsSection').show();
        $('#dashboardSection, #productsSection, #userAccountsSection').hide();
        // AJAX request to load transactions
        
    });

    // Click event for User Accounts button
    $('#btnUserAccounts').click(function() {
        $('#userAccountsSection').show();
        $('#dashboardSection, #productsSection, #transactionsSection').hide();
    
        // AJAX request to load user accounts
        
    });
    

    // Click event for Logout button
    $('#btnLogout').click(function() {
        // Implement logout functionality
        // Redirect to logout page or perform necessary actions
    });
});

$(document).ready(function() {
    // Click event for Add Product button
    $('#addProductButton').click(function() {
        Swal.fire({
            title: 'Add Product',
            html:
                `<input id="productName" class="swal2-input" placeholder="Product Name">
                 <input id="productDescription" class="swal2-input" placeholder="Description">
                 <input id="productPrice" class="swal2-input" placeholder="Price">
                 <input id="productQuantity" class="swal2-input" placeholder="Quantity Available">`,
            showCancelButton: true,
            confirmButtonText: 'Add Product',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const productName = Swal.getPopup().querySelector('#productName').value;
                const productDescription = Swal.getPopup().querySelector('#productDescription').value;
                const productPrice = Swal.getPopup().querySelector('#productPrice').value;
                const productQuantity = Swal.getPopup().querySelector('#productQuantity').value;
    
                // Check if any field is empty
                if (!productName || !productDescription || !productPrice || !productQuantity) {
                    Swal.showValidationMessage('Please fill all fields');
                    return false;
                }
    
                return $.ajax({
                    url: 'php/add_product.php',
                    method: 'POST',
                    data: {
                        productName: productName,
                        productDescription: productDescription,
                        productPrice: productPrice,
                        productQuantity: productQuantity
                    },
                    dataType: 'json'
                });
            }
        }).then((result) => {
            if (result.value && result.value.status === 'success') {
                // Product added successfully
                Swal.fire('Product Added', `${productName} has been added.`, 'success');
            } else {
                // Failed to add product
                Swal.fire('Error', 'Failed to add product', 'error');
            }
        }).catch((error) => {
            // Handle AJAX errors
            console.error(error);
            Swal.fire('Error', 'Failed to add product', 'error');
        });
    });
    
    $('#searchInput').on('input', function() {
        const searchText = $(this).val().toLowerCase();
        $('#productsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
        });
    });
});

function fetchInventoryData() {
    return $.ajax({
        url: 'php/get_inventory_data.php', // Replace with the correct path to your PHP file
        method: 'GET',
    });
}

// Function to render inventory chart
function renderInventoryChart(data) {
    const productNames = data.map(item => item.product_name);
    const quantities = data.map(item => item.quantity_available);

    const inventoryChartCanvas = document.getElementById('inventoryStatusChart').getContext('2d');
    const inventoryChart = new Chart(inventoryChartCanvas, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Quantity Available',
                data: quantities,
                backgroundColor: 'rgba(231, 76, 60, 0.6)' // Red color for bars
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

// Fetch inventory data and render chart on page load
$(document).ready(function() {
    fetchInventoryData()
        .done(function(response) {
            renderInventoryChart(response);
        })
        .fail(function(xhr, status, error) {
            console.error(error);
        });
});
//-----------------------------------------------------------//

//////////----------///////////////

////---------------------------------/////////////



function fetchOutOfStockProducts() {
    return $.ajax({
        url: 'php/out_of_stock.php', // Replace with the correct path to your PHP file
        method: 'GET',
    });
}

// Function to render Out of Stock table
function renderOutOfStockTable(data) {
    const outOfStockTableBody = $('#outOfStockTable tbody');
    outOfStockTableBody.empty(); // Clear previous data

    // Loop through the out of stock products and append rows to the table
    data.forEach(product => {
        const { product_id, product_name, description, price } = product;
        const row = `
            <tr>
                <td>${product_id}</td>
                <td>${product_name}</td>
                <td>${description}</td>
                <td>${price}</td>
                <!-- Add more columns if needed -->
            </tr>
        `;
        outOfStockTableBody.append(row);
    });
}

// Fetch and render Out of Stock products on page load
$(document).ready(function() {
    fetchOutOfStockProducts()
        .done(function(response) {
            renderOutOfStockTable(response);
        })
        .fail(function(xhr, status, error) {
            console.error(error);
        });
});

///----------------////////////////////////-----------

// Function to fetch and populate the Product Information table
function fetchProducts() {
    return $.ajax({
        url: 'php/get_products.php', // Replace with the correct path to your PHP file
        method: 'GET',
    });
}

// Function to render Product Information table
function renderProductTable(data) {
    const productTableBody = $('#productsTable tbody');
    productTableBody.empty(); // Clear previous data

    // Loop through products and append rows to the table
    data.forEach(product => {
        // Construct the row based on your product data structure
        // Append rows to the productTableBody
        productTableBody.append(`
            <tr>
                <td>${product.product_id}</td>
                <td>${product.product_name}</td>
                <td>${product.description}</td>
                <td>₱${product.price}</td>
                <td>${product.quantity_available}</td>
                <!-- Add more columns if needed -->
            </tr>
        `);
    });
}

// Function to handle refreshing Product Information table
function refreshProductTable() {
    fetchProducts()
        .done(function(response) {
            renderProductTable(response);
        })
        .fail(function(xhr, status, error) {
            console.error(error);
        });
}

// Click event for the refresh button
$(document).ready(function() {
    $('#refreshProductsButton').click(function() {
        refreshProductTable();
    });
});

// Initial loading of Product Information table on document ready
$(document).ready(function() {
    refreshProductTable();
});


// ---------------------------------------------------//
function fetchProductInTransactions() {
    // AJAX request to PHP endpoint
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Handle success response
                const transactions = JSON.parse(this.responseText);
                displayTransactionsIn(transactions);
            } else {
                // Handle error response
                console.error('Failed to fetch transactions. Server returned status:', this.status);
            }
        }
    };

    xhr.open('POST', 'php/fetch_product_in_transactions.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send();
}

function displayTransactionsIn(transactions) {
    const tableBody = document.getElementById('transactionsTableIn').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing data

    transactions.forEach(transaction => {
        const row = tableBody.insertRow();

        // Assuming the structure of the transaction object returned by the server
        const columns = ['product_id', 'product_name', 'quantity', 'received_date', 'empid', 'firstname'];

        columns.forEach(column => {
            const cell = row.insertCell();
            cell.innerText = transaction[column];
        });
    });
}

// Fetch and display product in transactions on page load
fetchProductInTransactions();



//----------------------------------//

function fetchProductOutTransactions() {
    // AJAX request to PHP endpoint
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Handle success response
                const transactions = JSON.parse(this.responseText);
                displayTransactionsOut(transactions);
            } else {
                // Handle error response
                console.error('Failed to fetch transactions. Server returned status:', this.status);
            }
        }
    };

    xhr.open('POST', 'php/fetch_product_out_transactions.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send();
}

function displayTransactionsOut(transactions) {
    const tableBody = document.getElementById('transactionsTableOut').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing data

    transactions.forEach(transaction => {
        const row = tableBody.insertRow();

        // Assuming the structure of the transaction object returned by the server
        const columns = ['product_id', 'product_name', 'quantity', 'received_date', 'empid', 'firstname'];

        columns.forEach(column => {
            const cell = row.insertCell();
            cell.innerText = transaction[column];
        });
    });
}

// Fetch and display product out transactions on page load
fetchProductOutTransactions();





//-------------------------//
$(document).ready(function() {
    $('#btnLogout').click(function() {
        Swal.fire({
            title: 'Confirm Logout',
            text: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to index.html after confirmation
                window.location.href = 'index.html';
            }
        });
    });
});

//--------------//
function fetchUserAccounts() {
    return $.ajax({
        url: 'php/get_users.php', // Adjust the PHP script name
        method: 'GET',
        dataType: 'json'
    });
}

function renderUserAccountsTable(data) {
    const userAccountsTableBody = $('#userAccountsTable tbody');
    userAccountsTableBody.empty(); // Clear previous data

    // Loop through user accounts and append rows to the table
    data.forEach(user => {
        userAccountsTableBody.append(`
            <tr>
                <td>${user.empid}</td>
                <td>${user.lastname}</td>
                <td>${user.firstname}</td>
                <td>${user.department}</td>
                <td>${user.username}</td>
                <td>${user.role}</td>
                <!-- Add more columns if needed -->
            </tr>
        `);
    });
}

// Fetch user accounts and render the table
fetchUserAccounts()
    .done(function(response) {
        renderUserAccountsTable(response);
    })
    .fail(function(xhr, status, error) {
        console.error(error);
    });