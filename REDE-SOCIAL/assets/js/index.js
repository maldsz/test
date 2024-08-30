// não mudar de posição caso contrário não irá funcionar o btn-menu expand! 
const btn_menu = document.querySelector(".btn-menu");
const side_bar = document.querySelector(".sidebar");
const searchBtn = document.querySelector(".search-btn");
const searchInput = document.querySelector(".search-input");

let isSidebarOpen = false;

btn_menu.addEventListener("click", function () {
    side_bar.classList.toggle("expand");
    changebtn();
    isSidebarOpen = !isSidebarOpen;
});

searchBtn.addEventListener("click", function () {
    if (!isSidebarOpen) {
        side_bar.classList.add("expand");
        changebtn();
        isSidebarOpen = true;
    } else {
        searchInput.focus();
    }
});

function changebtn() {
    btn_menu.classList.toggle("bx-menu-alt-right");
    btn_menu.classList.toggle("bx-menu");
}


document.querySelector(".create-link").addEventListener("click", function (event) {
    verificarAutenticacao();
});

document.querySelector(".bookmarks-link").addEventListener("click", function (event) {
    verificarAutenticacao();
});

document.querySelector(".profile-link").addEventListener("click", function (event) {
    verificarAutenticacao();
});

document.querySelector(".settings-link").addEventListener("click", function (event) {
    verificarAutenticacao();
});
