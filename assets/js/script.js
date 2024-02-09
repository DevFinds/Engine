AOS.init();

var myButton = document.getElementById("dashboard-collapse-button");
myButton.addEventListener("click", function() {
  toggleCollapse();
  collapse_user_menu();
});

function toggleCollapse() {
  myButton.classList.toggle("dashboard-collapse-button-active");
}
  
function collapse_user_menu() {
  var targetElement = document.getElementById("dashboard-collapse-menu");

  if (targetElement.style.display === "none" || targetElement.style.display === "") {
    targetElement.classList.add("animate__animated", "animate__fadeIn");
    targetElement.style.display = "block";
  } else {
    targetElement.style.display = "none";
  }
}

