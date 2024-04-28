var saveButton = document.getElementById("saveButton");
var modalTitle = document.getElementById("modalTitle");

function openBox(param) {
  document.getElementById(param).style.display = "block";
}

function closeBox(param) {
  document.getElementById(param).style.display = "none";
}

function openTab(tabName) {
  var i, tabContent;
  tabContent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabContent.length; i++) {
    tabContent[i].style.display = "none";
  }
  document.getElementById(tabName).style.display = "block";
}

function verify(val) {
  document.getElementById(val).style.display = "block";
}
window.onload = function () {
  var button = document.getElementById("alwaysClicked");
  button.click(); // Simulate a click event on the button
};
function confirmDelete() {
  // Ask for confirmation
  var confirmDelete = confirm("Are you sure you want to delete this product?");

  // If user confirms, return true to submit the form
  return confirmDelete;
}
function openInventory() {
  // Your JavaScript code to open the inventory
  return openTab("Inventory");
}

// Define the JavaScript function to display error message
function errMessage(message) {
  alert(message);
}

// Function to extract URL parameters
function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// Check if there's an error message in the URL and display it
document.addEventListener("DOMContentLoaded", function() {
  var errorMessage = getParameterByName('message');
  if(errorMessage) {
      errMessage(errorMessage);
  }
});

function logout(){
  var confirmLogout = confirm("Are you sure you want to logout?");

  if (confirmLogout){
    window.location.href = 'includes/logout.inc.php';
  }
}