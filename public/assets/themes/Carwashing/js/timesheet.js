const dateRange = document.getElementById('manage_company__date-range');
const table = document.getElementById('manage_company__schedule-table');
let currentMonth = 9; // Сентябрь
let currentYear = 2024; // 2024

// Подключаем flatpickr для выбора месяца и года
flatpickr(dateRange, {
    locale: "ru",
    dateFormat: "d M Y",
    defaultDate: new Date(currentYear, currentMonth - 1, 1),
    onChange: function (selectedDates, dateStr, instance) {
        const date = new Date(selectedDates[0]);
        currentMonth = date.getMonth() + 1;
        currentYear = date.getFullYear();
        updateDateRange();
        renderTable(currentMonth, currentYear);
    }
});

// Обновляем отображение диапазона дат
function updateDateRange() {
    const firstDay = new Date(currentYear, currentMonth - 1, 1);
    const lastDay = new Date(currentYear, currentMonth, 0);
    const monthName = firstDay.toLocaleDateString('ru-RU', { month: 'long' });
    dateRange.textContent = `1 ${monthName} ${currentYear} – ${lastDay.getDate()} ${monthName} ${currentYear}`;
}

// Генерируем таблицу графика
function renderTable(month, year) {
    const days = new Date(year, month, 0).getDate();
    const headerRow = table.querySelector('thead tr');
    const tbody = table.querySelector('tbody');

    // Очистка таблицы
    headerRow.innerHTML = '<th>Пользователь</th><th>Всего</th>';
    tbody.innerHTML = '';

    // Добавление дней месяца
    for (let day = 1; day <= days; day++) {
        const date = new Date(year, month - 1, day);
        const dayOfWeek = date.toLocaleDateString('ru-RU', { weekday: 'short' });
        headerRow.innerHTML += `<th>${day.toString().padStart(2, '0')}<br>${dayOfWeek}</th>`;
    }

    // Добавление данных сотрудников
    const users = ['Чертополох И.С.', 'Иванов И.И.', 'Петров П.П.'];
    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${user}</td><td class="total-column">120</td>`;
        for (let day = 1; day <= days; day++) {
            row.innerHTML += `<td class="hours">8</td>`;
        }
        tbody.appendChild(row);
    });
}

// Переход на предыдущий месяц
function prevMonth() {
    currentMonth--;
    if (currentMonth < 1) {
        currentMonth = 12;
        currentYear--;
    }
    updateDateRange();
    renderTable(currentMonth, currentYear);
}

// Переход на следующий месяц
function nextMonth() {
    currentMonth++;
    if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
    }
    updateDateRange();
    renderTable(currentMonth, currentYear);
}

// Инициализация
updateDateRange();
renderTable(currentMonth, currentYear);
