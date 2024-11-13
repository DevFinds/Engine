
// Функция для отображения выбранной вкладки "Страница продажи товаров и услуг"
function showTab(tab) {
    // Получаем элементы вкладок и контейнеров
    const carWashTab = document.querySelector(".tab:nth-child(1)");
    const cafeTab = document.querySelector(".tab:nth-child(2)");
    const carWashContainer = document.getElementById("carWashContainer");
    const cafeContainer = document.getElementById("cafeContainer");

    if (tab === "carWash") {
        // Показываем контейнер для автомойки и скрываем для кафе
        carWashContainer.style.display = "flex";
        cafeContainer.style.display = "none";

        // Делаем активной вкладку "Автомойка"
        carWashTab.classList.add("active");
        cafeTab.classList.remove("active");
    } else if (tab === "cafe") {
        // Показываем контейнер для кафе и скрываем для автомойки
        cafeContainer.style.display = "flex";
        carWashContainer.style.display = "none";

        // Делаем активной вкладку "Кафе"
        cafeTab.classList.add("active");
        carWashTab.classList.remove("active");
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
