document.addEventListener("DOMContentLoaded", () => {
    const userMenuToggler = document.getElementById("user-menu-toggler");
    const accountPopup = document.querySelector(".account-popup");

    if (!userMenuToggler || !accountPopup) {
        return; // Если элементы не найдены, ничего не делаем
    }

    // Функция для скрытия попапа при клике вне его области
    function hidePopupOnOutsideClick(event) {
        if (!accountPopup.contains(event.target) && !userMenuToggler.contains(event.target)) {
            accountPopup.classList.add("hidden");
            document.removeEventListener("click", hidePopupOnOutsideClick);
        }
    }

    // Обработчик клика по кнопке
    userMenuToggler.addEventListener("click", (event) => {
        event.stopPropagation(); // Предотвращаем всплытие события
        accountPopup.classList.toggle("hidden");

        // Добавляем обработчик для скрытия попапа при клике вне его
        if (!accountPopup.classList.contains("hidden")) {
            document.addEventListener("click", hidePopupOnOutsideClick);
        }
    });
});





document.addEventListener('DOMContentLoaded', () => {
    // Находим первую вкладку на странице
    const firstTab = document.querySelector('.tab[data-tab]');
    if (firstTab) {
        const defaultTabName = firstTab.getAttribute('data-tab');
        switchTab(defaultTabName); // Устанавливаем первую вкладку активной
    }
});


/*************  ✨ Codeium Command ⭐  *************/
/**
 * Switches the active tab to the specified tab name.
 * 


/******  39462a2d-d07b-4da3-a716-cbb40e1482a8  *******/
function switchTab(tabName) {
    console.log(`Переключение на вкладку: ${tabName}`); // Проверяем вызов функции

    // Убираем активный класс со всех вкладок
    const tabs = document.querySelectorAll(".tab");
    tabs.forEach(tab => tab.classList.remove("active"));

    // Добавляем активный класс к текущей вкладке
    const activeTab = document.querySelector(`.tab[data-tab="${tabName}"]`);
    if (activeTab) {
        activeTab.classList.add("active");
        console.log(`Активная вкладка: ${tabName}`);
    } else {
        console.warn(`Вкладка с data-tab="${tabName}" не найдена.`);
    }

    // Прячем все контейнеры вкладок
    const tabContents = document.querySelectorAll(".tab-content");
    tabContents.forEach(content => {
        content.style.display = "none";
        content.style.opacity = "0";
        content.style.visibility = "hidden";
    });

    // Показываем активный контейнер
    const activeContent = document.getElementById(`${tabName}Container`);
    if (activeContent) {
        activeContent.style.display = "flex"; // Или "flex"
        activeContent.style.opacity = "1";
        activeContent.style.visibility = "visible";
        console.log(`Контейнер с ID '${tabName}Container' отображён.`);
    } else {
        console.error(`Контейнер с ID '${tabName}Container' не найден.`);
    }
}


function switchTab_group(group, tabName) {
    console.log(`Переключение на вкладку: ${tabName} в группе: ${group}`); 

    // Убираем активный класс со всех вкладок в группе
    const tabs = document.querySelectorAll(`.analitics-tab[data-group="${group}"]`);
    tabs.forEach(tab => tab.classList.remove("active"));

    // Добавляем активный класс к текущей вкладке
    const activeTab = document.querySelector(`.analitics-tab[data-group="${group}"][data-tab="${tabName}"]`);
    if (activeTab) {
        activeTab.classList.add("active");
    } else {
        console.warn(`Вкладка с data-tab="${tabName}" в группе "${group}" не найдена.`);
    }

    // Прячем все контейнеры вкладок в группе
    const tabContents = document.querySelectorAll(`.tab-content[data-group="${group}"]`);
    tabContents.forEach(content => {
        content.style.display = "none";
        content.style.opacity = "0";
        content.style.visibility = "hidden";
    });

    // Показываем активный контейнер
    const activeContent = document.querySelector(`#${tabName}Container${group === 'services' ? '-services' : ''}`);
    if (activeContent) {
        activeContent.style.display = "flex";
        activeContent.style.opacity = "1";
        activeContent.style.visibility = "visible";
    } else {
        console.error(`Контейнер с ID '${tabName}Container' для группы '${group}' не найден.`);
    }
}




function togglePayment(paymentType) {
    // Получаем кнопки
    const cashButton = document.querySelector('.payment-buttons .payment-button:nth-child(1)');
    const cardButton = document.querySelector('.payment-buttons .payment-button:nth-child(2)');

    // Снимаем активный класс со всех кнопок
    cashButton.classList.remove('active');
    cardButton.classList.remove('active');

    // Устанавливаем активный класс на выбранную кнопку
    if (paymentType === 'cash') {
        cashButton.classList.add('active');
    } else if (paymentType === 'card') {
        cardButton.classList.add('active');
    }
}


function toggleNoteField(noteFieldId) {
    // Находим поле по его id
    const noteFieldContainer = document.getElementById(noteFieldId);

    // Если элемент найден, переключаем класс "open"
    if (noteFieldContainer) {
        noteFieldContainer.classList.toggle('open');
    } else {
        console.error(`Элемент с id "${noteFieldId}" не найден.`);
    }
}





