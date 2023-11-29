function signOut() {
  window.location.href = "index.html"; // Redirect to index.html
}
function goToInventory() {
  window.location.href = "inventory.php"; // Redirect to inventory

}

function goToPOS() {
  window.location.href = "pos.php"; // Redirect to POS
}

//----------------------------------//
$(document).ready(function() {
  // Function to hide all sections except the provided one
  function hideAllSections(exceptSection) {
    $('.section').not(exceptSection).hide();
    $(exceptSection).show();
  }

  // Show Product Management section by default
  hideAllSections('#productManagementSection');

  // Click event for Product List button
  $('#btnProductList').click(function() {
    hideAllSections('#productListSection');
    $('#productManagementSection').hide(); // Hide Product Management section
    // AJAX request to load products...
    // (rest of the AJAX code remains the same)
  });

  // Click event for Product Management button
  $('#btnProducts').click(function() {
    hideAllSections('#productManagementSection');
      // Using AJAX to fetch updated data from the server
      let xhr = new XMLHttpRequest();
  
      xhr.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
              // Update the table content with the fetched data
              document.getElementById("productListSection").innerHTML = this.responseText;
          }
      };
  
      xhr.open("GET", "php/refresh_products.php", true); // Assuming PHP script to fetch updated data is 'fetch_products.php'
      xhr.send();
     
  });
});
///---------------------///
//-----------------------------------//

function searchProduct() {
  const searchValue = document.getElementById('searchInput').value;

  fetch(`php/search_product.php?search=${searchValue}`)
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
          if (data.length > 0) {
              const product = data[0];
              document.getElementById('productId').value = product.product_id;
              document.getElementById('productName').value = product.product_name;
              document.getElementById('productDescription').value = product.description;
              document.getElementById('productPrice').value = product.price;

              // Updated part for the quantity available field
              document.getElementById('productQuantity').value = product.stocks_qnt !== null ? product.stocks_qnt : 'N/A';
          } else {
              // Clear the fields if no product found
              document.getElementById('productId').value = '';
              document.getElementById('productName').value = '';
              document.getElementById('productDescription').value = '';
              document.getElementById('productPrice').value = '';
              document.getElementById('productQuantity').value = 'N/A';
              alert('Product not found!');
          }
      })
      .catch(error => {
          console.error('Error:', error.message);
          // Display user-friendly error message if needed
      });
}

///--------------------------------------///


///-----------------------------------------------///

function addProduct() {
  // Fetch input values
  let productName = document.getElementById("productName").value;
  let productDescription = document.getElementById("productDescription").value;
  let productPrice = document.getElementById("productPrice").value;
  let productQuantity = document.getElementById("productQuantity").value;

  // Create a data object to send via POST request
  let data = new FormData();
  data.append('productName', productName);
  data.append('productDescription', productDescription);
  data.append('productPrice', productPrice);
  data.append('productQuantity', productQuantity);

  // AJAX request using XMLHttpRequest
  let xhr = new XMLHttpRequest();
  xhr.open('POST', 'php/add_inventory.php', true);
  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              let response = JSON.parse(xhr.responseText);
              if (response.success) {
                  // Show success message using SweetAlert or any other method
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: response.message
                  });
                  // You may also want to clear the input fields here
              } else {
                  // Show error message
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: response.message
                  });
              }
          } else {
              // Show error message if status is not 200 (e.g., server error)
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Something went wrong!'
              });
          }
      }
  };
  xhr.send(data);
}




///-------------------------------------------------///


function deleteProduct() {
  let productIdToDelete = $('#productId').val(); // Get the product ID from the input field

  // AJAX request to delete_product.php
  $.ajax({
      type: 'POST',
      url: 'php/delete_product.php',
      data: { productId: productIdToDelete }, // Send the product ID to the PHP script
      dataType: 'json',
      success: function(response) {
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message
          }); // Show success message

              // Clear input field values upon successful deletion
              $('#productId').val('');
              $('#productName').val('');
              $('#productDescription').val('');
              $('#productPrice').val('');
              $('#productQuantity').val('');


          } else {
              alert(response.message); // Show error message
          }
      },
      error: function(xhr, status, error) {
          alert('Something went wrong!'); // Show error message if AJAX request fails
      }
  });
}






////-----------------------------------------------------------------------///
function editProduct() {
  let productId = document.getElementById('productId').value;
  let productName = document.getElementById('productName').value;
  let productDescription = document.getElementById('productDescription').value;
  let productPrice = document.getElementById('productPrice').value;
  let productQuantity = document.getElementById('productQuantity').value;

  // Construct the data to be sent
  let data = {
      productId: productId,
      productName: productName,
      productDescription: productDescription,
      productPrice: productPrice,
      productQuantity: productQuantity
  };

  // AJAX request using fetch API
  fetch('php/edit_product.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
      // Handle the response here
      // Show success/failure message using SweetAlert
      if (data.success) {
          swal.fire("Success!", "Product updated successfully.", "success");
          // Additional actions after successful update (if needed)
      } else {
          swal.fire("Error!", "Failed to update product.", "error");
      }
  })
  .catch((error) => {
      swal.fire("Error!", "An error occurred while updating product.", "error");
  });
}
//////--------------------/////////////////

function clearFields(){
  $('#productId').val('');
  $('#productName').val('');
  $('#productDescription').val('');
  $('#productPrice').val('');
  $('#productQuantity').val('');


}



////////-----------------------------------------/////////////
function filterTable() {
    let input, filter, table, tr, td_id, td_name, i, txtValue_id, txtValue_name;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("stocksTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td_id = tr[i].getElementsByTagName("td")[0];
        td_name = tr[i].getElementsByTagName("td")[1];
        if (td_id && td_name) {
            txtValue_id = td_id.textContent || td_id.innerText;
            txtValue_name = td_name.textContent || td_name.innerText;
            if (txtValue_id.toUpperCase().indexOf(filter) > -1 || txtValue_name.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


///---------------------------------------------//////////
function filterStocks() {
    let searchInput = document.getElementById("searchInput").value.trim();
    
    if (searchInput !== '') {
        let xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                // Update the table with the filtered products
                document.getElementById("stocksTable").innerHTML = this.responseText;
            }
        };
        
        xhr.open("GET", `php/filter_products.php?search=${searchInput}`, true);
        xhr.send();
    } else {
        alert("Please enter a search term");
    }
}