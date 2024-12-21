document.addEventListener('DOMContentLoaded', () => {
    // Находим первую вкладку на странице
    const firstTab = document.querySelector('.tab[data-tab]');
    if (firstTab) {
        const defaultTabName = firstTab.getAttribute('data-tab');
        switchTab(defaultTabName); // Устанавливаем первую вкладку активной
    }
});
function switchTab(tabElement, tabName) {
    // Получаем родительский контейнер текущей группы
    const tabsGroup = tabElement.closest('.tabs-group');

    // Убираем активный класс со всех вкладок текущей группы
    const tabs = tabsGroup.querySelectorAll(".tab");
    tabs.forEach(tab => tab.classList.remove("active"));

    // Добавляем активный класс к текущей вкладке
    tabElement.classList.add("active");

    // Прячем все контейнеры вкладок текущей группы
    const tabContents = tabsGroup.querySelectorAll(".tab-content");
    tabContents.forEach(content => {
        content.style.display = "none";
        content.style.opacity = "0";
        content.style.visibility = "hidden";
    });

    // Показываем активный контейнер
    const activeContent = tabsGroup.querySelector(`#${tabName}Container`);
    if (activeContent) {
        activeContent.style.display = "flex"; // Или "block"
        activeContent.style.opacity = "1";
        activeContent.style.visibility = "visible";
    } else {
        console.error(`Контейнер с ID '${tabName}Container' не найден.`);
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

function switchTabGeneral(tabElement, tabName) {
    // Определяем группу табов
    const group = tabElement.closest('[data-group]').getAttribute('data-group');

    // Убираем активный класс со всех вкладок в группе
    const tabs = document.querySelectorAll(`[data-group="${group}"] .analitics-tab`);
    tabs.forEach(tab => tab.classList.remove('active'));

    // Добавляем активный класс к текущей вкладке
    tabElement.classList.add('active');

    // Прячем все таб-контейнеры в группе
    const tabContents = document.querySelectorAll(`[data-group="${group}"] .tab-content`);
    tabContents.forEach(content => {
        content.style.display = 'none'; // Скрываем контент
        content.style.opacity = '0';   // Для анимации
        content.style.visibility = 'hidden'; // Скрываем визуально
    });

    // Показываем активный таб-контейнер
    const activeContent = document.querySelector(`[data-group="${group}"] #${tabName}Container`);
    if (activeContent) {
        activeContent.style.display = 'block'; // Показываем контент
        activeContent.style.opacity = '1';    // Для анимации
        activeContent.style.visibility = 'visible'; // Отображаем визуально
    } else {
        console.error(`Контейнер с ID '${tabName}Container' не найден.`);
    }
}

