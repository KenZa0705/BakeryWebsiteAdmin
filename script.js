var modal = document.getElementById("productModal");
var saveButton = document.getElementById("saveButton");
var modalTitle = document.getElementById("modalTitle");
var productNameInput = document.getElementById("Name");
var productPriceInput = document.getElementById("Price");
var productPriceInput = document.getElementById("Quantity");
var productPriceInput = document.getElementById("Description");
var inventoryContainer = document.getElementById("inventoryContainer");

// Initialize metrics
var totalProductCount = 0;
var lowStockProductCount = 0;
var outOfStockProductCount = 0;

function openModal(title) {
  modal.style.display = "block";
  modalTitle.textContent = title;
}

function closeModal() {
  modal.style.display = "none";
  productNameInput.value = "";
  productPriceInput.value = "";
}

function updateMetrics() {
  totalProducts.textContent = totalProductCount;
  lowStockProducts.textContent = lowStockProductCount;
  outOfStockProducts.textContent = outOfStockProductCount;
}

function toggleInventory() {
  inventoryContainer.classList.toggle("hidden");
}

function addProduct() {
  openModal("Add Product");
}

function saveProduct() {
  var productName = productNameInput.value;
  var productPrice = productPriceInput.value;
  
  if (productName.trim() === "" || productPrice.trim() === "") {
    alert("Please enter product name and price.");
    return;
  }

  var newItem = document.createElement("div");
  newItem.innerHTML = "<p><strong>" + productName + "</strong>: $" + productPrice + "</p>";
  inventoryList.appendChild(newItem);

  // Update metrics
  totalProductCount++;
  updateMetrics();

  // Example: Check if the product is low stock
  if (totalProductCount < 5) {
    lowStockProductCount++;
    updateMetrics();
  }

  // Example: Check if the product is out of stock
  if (totalProductCount === 0) {
    outOfStockProductCount++;
    updateMetrics();
  }

  closeModal();
}



// Example data for demonstration
var totalProductsCount = 100;
var lowStockProductsCount = 10;
var outOfStockProductsCount = 5;

// Update metrics with example data
document.getElementById("totalProducts").textContent = totalProductsCount;
document.getElementById("lowStockProducts").textContent = lowStockProductsCount;
document.getElementById("outOfStockProducts").textContent = outOfStockProductsCount;



function login() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Check for valid credentials
    if ((username === 'john' && password === 'ison') || (username === 'kent' && password === 'cuenza') || (username === 'jericho' && password === 'encinares')) {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('admin-dashboard').style.display = 'block';
        return false; // Prevent form submission
    } else {
        alert('Invalid credentials. Please try again.');
        return false; // Prevent form submission
    }
}

function openTab(tabName) {
    var i, tabContent;
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";

}

function search() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("searchResults");
    li = ul.getElementsByTagName('li');
  
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
  
