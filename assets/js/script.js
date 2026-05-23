var buton = document.querySelector(".menu-buton");
var menu = document.querySelector(".sol-menu");

if (buton && menu) {
  buton.onclick = function () {
    menu.classList.toggle("acik");
  };
}
