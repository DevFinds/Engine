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

// Функция click to copy to clipboard
var copyButton = document.getElementById('copy-to-clipboard');
if (copyButton) {
    copyButton.addEventListener('click', function() {
        let text = document.getElementById('copy-to-clipboard').innerText;
        copyContent(text);
    });
}

async function copyContent(text) {
    try {
        await navigator.clipboard.writeText(text);
        console.log('Content copied to clipboard');
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}
