var modal = document.getElementById("productModal");
var saveButton = document.getElementById("saveButton");
var modalTitle = document.getElementById("modalTitle");

function openModal(title) {
  modal.style.display = "block";
  modalTitle.textContent = title;
}

function closeModal() {
  modal.style.display = "none";
  productNameInput.value = "";
  productPriceInput.value = "";
}

function toggleInventory() {
  inventoryContainer.classList.toggle("hidden");
}

function addProduct() {
  openModal("Add Product");
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
  
