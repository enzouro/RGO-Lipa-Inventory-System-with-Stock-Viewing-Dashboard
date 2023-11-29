function exit() {
    window.location.href = "index.html";
  }


  window.onload = function() {
 
      // Using AJAX to fetch updated data from the server
      let xhr = new XMLHttpRequest();
  
      xhr.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
              // Update the table content with the fetched data
              document.getElementById("productListSection").innerHTML = this.responseText;
          }
      };
  
      xhr.open("GET", "php/fetch_client.php", true); // Assuming PHP script to fetch updated data is 'fetch_products.php'
      xhr.send();
  };