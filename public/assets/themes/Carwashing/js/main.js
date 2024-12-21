document.addEventListener('DOMContentLoaded', () => {
    // Находим первую вкладку на странице
    const firstTab = document.querySelector('.tab[data-tab]');
    if (firstTab) {
        const defaultTabName = firstTab.getAttribute('data-tab');
        switchTab(defaultTabName); // Устанавливаем первую вкладку активной
    }
});


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

