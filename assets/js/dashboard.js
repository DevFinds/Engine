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
    targetElement.style.display = "flex";
  } else {
    targetElement.style.display = "none";
  }
}

function switchTab(tabId) {
  // Скрываем все элементы
  document.getElementById('users-table-container').style.display = 'none';
  document.getElementById('users-create-user-form').style.display = 'none';
  document.getElementById('users-role-editor').style.display = 'none';

  // Отображаем выбранный элемент
  document.getElementById(tabId).style.display = 'flex';
  document.getElementById(tabId).classList.add('animate__animated', 'animate__fadeIn');
}

// Устанавливаем начальное отображение для users-table-container
document.getElementById('users-table-container').style.display = 'flex';

// Обработчики событий для кнопок
document.getElementById('users-user-list-tab').addEventListener('click', function() {
  switchTab('users-table-container');
});

document.getElementById('users-create-user-tab').addEventListener('click', function() {
  switchTab('users-create-user-form');
});

document.getElementById('users-role-editor-tab').addEventListener('click', function() {
  switchTab('users-role-editor');
});


// Функция click to copy to clipboard

let text = document.getElementById('copy-to-clipboard').innerHTML;
  const copyContent = async () => {
    try {
      await navigator.clipboard.writeText(text);
      console.log('Content copied to clipboard');
    } catch (err) {
      console.error('Failed to copy: ', err);
    }
  }