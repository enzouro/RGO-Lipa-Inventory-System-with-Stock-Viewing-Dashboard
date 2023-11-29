
window.onload = function() {
    // Find the button element by its ID
    var button = document.getElementById('btnProductList');
  
    // Simulate a click on the button
    button.click();
  };
////////////-----------------------------//////////////////
function exitBtn(){
    windows.location.href = 'employee.php';
};

document.getElementById('btnExit').addEventListener('click', function() {
    exitBtn()
});

function exit() {
    window.location.href = "index.html";
  }

  ///-----------------------------------------------------------////

// Function to confirm an update and trigger updateQuantity and insertDetails
function confirmUpdate(action, productId, currentQuantity) {
    Swal.fire({
        title: `Enter quantity to ${action}`,
        input: 'number',
        inputValue: 1,
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value || value < 1 || value % 1 !== 0) {
                return 'Please enter a valid quantity';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const quantity = parseInt(result.value);

            // Call function to update quantity via AJAX
            updateQuantity(productId, quantity, action, currentQuantity);

            // Call function to insert details based on the action
            if (action === 'add') {
                insertInStocksDetails(productId, quantity);
            } else if (action === 'subtract') {
                insertOutStocksDetails(productId, quantity);
            }
        }
    });
}

// Function to update quantity via AJAX
function updateQuantity(productId, quantity, action, currentQuantity) {
    // AJAX request to PHP endpoint
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Handle success response
                Swal.fire({
                    icon: 'success',
                    title: 'Quantity Updated',
                    text: 'The quantity has been updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Optionally, update the displayed quantity on the UI
                    const updatedQuantity = action === 'add' ? currentQuantity + quantity : currentQuantity - quantity;
                    document.getElementById(`quantity-${productId}`).innerText = updatedQuantity;
                });
            } else {
                // Handle error response
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update quantity'
                });
            }
        }
    };

    xhr.open('POST', 'php/update_quantity.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(`productId=${productId}&quantity=${quantity}&action=${action}&empid=2`);
}

// Function to insert instocks details via AJAX
function insertInStocksDetails(productId, addedQuantity) {
    // AJAX request to PHP endpoint
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Handle success response
                const response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    console.log('Details inserted successfully:', response.message);
                } else {
                    console.error('Failed to insert details:', response.message);
                }
            } else {
                // Handle error response
                console.error('Failed to insert details. Server returned status:', this.status);
            }
        }
    };

    xhr.open('POST', 'php/insert_instocks_details.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(`productId=${productId}&addedQuantity=${addedQuantity}&empid=2`);
}

// Function to insert outstocks details via AJAX
function insertOutStocksDetails(productId, outQuantity) {
    // AJAX request to PHP endpoint
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Handle success response
                const response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    console.log('Details inserted successfully:', response.message);
                } else {
                    console.error('Failed to insert details:', response.message);
                }
            } else {
                // Handle error response
                console.error('Failed to insert details. Server returned status:', this.status);
            }
        }
    };

    xhr.open('POST', 'php/insert_outstocks_details.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(`productId=${productId}&outQuantity=${outQuantity}&empid=2`);
}

////------------------------------------------------////////////
///---------------------///