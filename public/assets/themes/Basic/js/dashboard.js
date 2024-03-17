AOS.init();

var myButton = document.getElementById("dashboard-collapse-button");
if (myButton) {
    myButton.addEventListener("click", function() {
        toggleCollapse();
        collapse_user_menu();
    });
}

function toggleCollapse() {
    if (myButton) {
        myButton.classList.toggle("dashboard-collapse-button-active");
    }
}

function collapse_user_menu() {
    var targetElement = document.getElementById("dashboard-collapse-menu");

    if (targetElement) {
        if (targetElement.style.display === "none" || targetElement.style.display === "") {
            targetElement.classList.add("animate__animated", "animate__fadeIn");
            targetElement.style.display = "flex";
        } else {
            targetElement.style.display = "none";
        }
    }
}

function switchTab(tabId) {
    // Получаем все элементы вкладок
    var usersTableContainer = document.getElementById('users-table-container');
    var createUserForm = document.getElementById('users-create-user-form');
    var roleEditor = document.getElementById('users-role-editor');

    // Убираем классы анимации и плавности у текущих видимых вкладок
    if (usersTableContainer && usersTableContainer.style.display === 'flex') {
        usersTableContainer.classList.remove('animate__animated', 'animate__fadeIn');
    }
    if (createUserForm && createUserForm.style.display === 'flex') {
        createUserForm.classList.remove('animate__animated', 'animate__fadeIn');
    }
    if (roleEditor && roleEditor.style.display === 'flex') {
        roleEditor.classList.remove('animate__animated', 'animate__fadeIn');
    }

    // Скрываем все элементы
    if (usersTableContainer) {
        usersTableContainer.style.display = 'none';
    }
    if (createUserForm) {
        createUserForm.style.display = 'none';
    }
    if (roleEditor) {
        roleEditor.style.display = 'none';
    }

    // Отображаем выбранный элемент
    var selectedTab = document.getElementById(tabId);

    if (selectedTab) {
        selectedTab.style.display = 'flex'; // Изменил на 'flex'
        selectedTab.classList.add('animate__animated', 'animate__fadeIn');
    }
}

// Устанавливаем начальное отображение для users-table-container
var initialUserTableContainer = document.getElementById('users-table-container');
if (initialUserTableContainer) {
    initialUserTableContainer.style.display = 'flex';
}

// Обработчики событий для кнопок
var userListTab = document.getElementById('users-user-list-tab');
if (userListTab) {
    userListTab.addEventListener('click', function() {
        switchTab('users-table-container');
    });
}

var createUserTab = document.getElementById('users-create-user-tab');
if (createUserTab) {
    createUserTab.addEventListener('click', function() {
        switchTab('users-create-user-form');
    });
}

var roleEditorTab = document.getElementById('users-role-editor-tab');
if (roleEditorTab) {
    roleEditorTab.addEventListener('click', function() {
        switchTab('users-role-editor');
    });
}

document.addEventListener("DOMContentLoaded", function() {
    var currentPage = window.location.pathname;

    // Находим текущую страницу среди пунктов меню и изменяем их стили
    document.querySelectorAll(".dashboard-menu-link").forEach(function(link) {
        var page = link.getAttribute("href");

        if (currentPage === page) {
            link.classList.add("dashboard-menu-link-active");
            link.previousElementSibling.classList.add("dashboard-link-icon-active");
        }
    });
});

// Получаем все кнопки
var userListTab = document.getElementById('users-user-list-tab');
var createUserTab = document.getElementById('users-create-user-tab');
var roleEditorTab = document.getElementById('users-role-editor-tab');

// Добавляем обработчики событий для каждой кнопки
userListTab.addEventListener('click', function() {
    setActiveTab(userListTab);
});
createUserTab.addEventListener('click', function() {
    setActiveTab(createUserTab);
});
roleEditorTab.addEventListener('click', function() {
    setActiveTab(roleEditorTab);
});

// Функция для изменения стилей активной кнопки
function setActiveTab(activeTab) {
    // Удаляем класс active у всех кнопок
    var buttons = document.querySelectorAll('.users-selector-buttons button');
    buttons.forEach(function(button) {
        button.classList.remove('active');
    });
    // Добавляем класс active только к активной кнопке
    activeTab.classList.add('active');
}



