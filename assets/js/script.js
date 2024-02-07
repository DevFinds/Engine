AOS.init();

var myButton = document.getElementById("collapse-button");
myButton.addEventListener("click", function() {
  toggleCollapse();
  collapse_user_menu();
});

function toggleCollapse() {
  myButton.classList.toggle("collapse-button-active");
}
  
function collapse_user_menu() {
  var targetElement = document.getElementById("collapse-menu");

  if (targetElement.style.display === "none" || targetElement.style.display === "") {
    targetElement.classList.add("animate__animated", "animate__fadeIn");
    targetElement.style.display = "block";
  } else {
    targetElement.style.display = "none";
  }
}

