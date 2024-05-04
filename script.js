var saveButton = document.getElementById("saveButton");
var modalTitle = document.getElementById("modalTitle");
//Open and Close Divs
function openBox(param) {
  document.getElementById(param).style.display = "block";
}

function closeBox(param) {
  document.getElementById(param).style.display = "none";
}
//Change Tabs
function openTab(tabName) {
  var i, tabContent;
  tabContent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabContent.length; i++) {
    tabContent[i].style.display = "none";
  }
  document.getElementById(tabName).style.display = "block";
}
//Secuirty
function verify(val) {
  document.getElementById(val).style.display = "block";
}

//Button Clicker
window.onload = function () {
  var button = document.getElementById("alwaysClicked");
  button.click();
};

//Delete confirmation
function confirmDelete() {
  var confirmDelete = confirm("Are you sure you want to delete this product?");
  return confirmDelete;
}

//error alert
function errMessage(message) {
  alert(message);
}

//for error codes
function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

document.addEventListener("DOMContentLoaded", function() {
  var errorMessage = getParameterByName('message');
  if(errorMessage) {
      errMessage(errorMessage);
  }
});


//logout confirmation and redirection
function logout(){
  var confirmLogout = confirm("Are you sure you want to logout?");

  if (confirmLogout){
    window.location.href = 'includes/logout.inc.php';
  }
}
