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
    var menuItems = document.querySelectorAll(".dashboard-menu-item");

    // Добавляем обработчики событий для каждого элемента меню
    menuItems.forEach(function(item) {
        var link = item.querySelector(".dashboard-menu-link");
        var icon = item.querySelector(".dashboard-link-icon");

        item.addEventListener("click", function(event) {
            // Удаляем классы активных элементов у всех пунктов меню
            menuItems.forEach(function(menuItem) {
                menuItem.classList.remove("dashboard-menu-item-active");
            });

            // Удаляем класс активной ссылки у всех ссылок
            document.querySelectorAll(".dashboard-menu-link").forEach(function(menuLink) {
                menuLink.classList.remove("dashboard-menu-link-active");
            });

            // Удаляем класс активной иконки у всех иконок
            document.querySelectorAll(".dashboard-link-icon").forEach(function(menuIcon) {
                menuIcon.classList.remove("dashboard-link-icon-active");
            });

            // Добавляем класс активного элемента к выбранному пункту меню
            item.classList.add("dashboard-menu-item-active");

            // Добавляем класс активной ссылки к выбранной ссылке
            link.classList.add("dashboard-menu-link-active");

            // Добавляем класс активной иконки к выбранной иконке
            icon.classList.add("dashboard-link-icon-active");
        });
    });
});