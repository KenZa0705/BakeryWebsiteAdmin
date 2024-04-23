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
window.onload = function() {
  var button = document.getElementById("alwaysClicked");
  button.click(); // Simulate a click event on the button
};
