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
    const moveButtons = document.querySelectorAll('.warehouse-button'); // Получаем все кнопки "Переместить"
    const popup = document.getElementById('warehouse-move-popup');
    const selectedItemsList = document.getElementById('warehouse-selected-items');
    const closePopupButton = document.getElementById('warehouse-close-popup');
    const confirmMoveButton = document.getElementById('warehouse-confirm-move');
    const tabs = document.querySelectorAll('.tab'); // Все вкладки

    let selectedItems = {}; // Хранить выбранные товары по вкладкам
    let currentTab = 'warehouseOOO'; // По умолчанию первая вкладка

    // Установить начальную структуру для хранения товаров
    tabs.forEach(tab => {
        const tabName = tab.getAttribute('data-tab');
        selectedItems[tabName] = [];
    });

    // Обновить текущую вкладку при переключении
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            currentTab = tab.getAttribute('data-tab');
        });
    });

    // Выделение строки при клике
    document.querySelectorAll('[id^="warehouse-table"]').forEach(table => {
        table.addEventListener('click', (event) => {
            const row = event.target.closest('tr');
            if (!row) return;

            const rowId = row.querySelector('td:first-child').innerText; // ID товара
            const rowName = row.querySelector('td:nth-child(2)').innerText; // Имя товара
            const rowAmount = row.querySelector('td:nth-child(3)').innerText; // Количество

            const tabItems = selectedItems[currentTab]; // Товары текущей вкладки

            // Если строка уже выбрана
            if (row.classList.contains('selected')) {
                row.classList.remove('selected'); // Убираем подсветку
                selectedItems[currentTab] = tabItems.filter(item => item.id !== rowId);
            } else {
                // Добавляем подсветку
                row.classList.add('selected');
                tabItems.push({ id: rowId, name: rowName, amount: rowAmount });
            }
        });
    });

    // Показать попап с выбранными товарами
    moveButtons.forEach(button => {
        button.addEventListener('click', () => {
            selectedItemsList.innerHTML = ''; // Очистить предыдущие данные
            const tabItems = selectedItems[currentTab]; // Только товары текущей вкладки

            tabItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${item.name} - ${item.amount} шт.
                    <input type="number" min="1" max="${item.amount}" value="1" data-id="${item.id}" style="width: 60px;">
                `;
                selectedItemsList.appendChild(listItem);
            });

            if (tabItems.length > 0) {
                popup.classList.remove('hidden');
            } else {
                alert('Выберите товары для перемещения.');
            }
        });
    });

    // Закрыть попап
    closePopupButton.addEventListener('click', () => {
        popup.classList.add('hidden');
    });

    // Подтвердить перемещение
    confirmMoveButton.addEventListener('click', () => {
        const updatedItems = [];
        const inputs = selectedItemsList.querySelectorAll('input');
    
        console.log('Updated Items (before):', updatedItems); // Проверяем, какие товары выбраны (пустой массив)
    
        inputs.forEach(input => {
            const itemId = input.getAttribute('data-id');
            const newAmount = parseInt(input.value); // Используем parseInt для преобразования в число
            const item = selectedItems[currentTab].find(i => i.id === itemId);
            if (item && newAmount > 0) {
                updatedItems.push({ ...item, newAmount });
            }
        });
    
        console.log('Перемещаемые товары:', updatedItems);
    
        if (updatedItems.length === 0) {
            alert('Выберите товары и укажите корректное количество.');
            popup.classList.add('hidden');
            return;
        }
    
        // Определяем исходный и целевой склады
        let source_warehouse_id;
        if (currentTab === 'warehouseOOO') {
            source_warehouse_id = 1; // ООО
        } else if (currentTab === 'warehouseIP') {
            source_warehouse_id = 2; // ИП
        }
        const destination_warehouse_id = source_warehouse_id === 1 ? 2 : 1;
    
        // Формируем данные для отправки
        const productsToMove = updatedItems.map(item => ({
            product_id: item.id,
            quantity: item.newAmount
        }));
    
        console.log('Data to send:', {
            source_warehouse_id,
            destination_warehouse_id,
            products: productsToMove
        }); // Проверяем данные перед отправкой
    
        // Отправляем AJAX-запрос
        fetch('/admin/dashboard/goods_and_services/moveProducts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                source_warehouse_id,
                destination_warehouse_id,
                products: productsToMove
            })
        })
    
    
        .then(response => {
            console.log('Response status:', response.status); // Проверяем статус ответа
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data); // Проверяем ответ сервера
            if (data.success) {
                alert('Товары успешно перемещены');
                popup.classList.add('hidden');
                location.reload();
            } else {
                alert('Ошибка при перемещении товаров: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error); // Ловим ошибки AJAX
            alert('Произошла ошибка при перемещении товаров');
        });
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





