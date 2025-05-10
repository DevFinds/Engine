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
    // Элементы для перемещения
    const moveButtons = document.querySelectorAll('.move-button');
    const movePopup = document.getElementById('warehouse-move-popup');
    const selectedItemsList = document.getElementById('warehouse-selected-items');
    const closeMovePopupButton = document.getElementById('warehouse-close-popup');
    const confirmMoveButton = document.getElementById('warehouse-confirm-move');

    // Элементы для удаления
    const deleteButtons = document.querySelectorAll('.delete-button');
    const deletePopup = document.getElementById('warehouse-delete-popup');
    const deleteItemsList = document.getElementById('warehouse-delete-items');
    const confirmDeleteButton = document.getElementById('warehouse-confirm-delete');
    const cancelDeleteButton = document.getElementById('warehouse-cancel-delete');

    const tabs = document.querySelectorAll('.tab');
    let selectedItems = {};
    let currentTab = 'warehouseOOO';

    console.log('Найдено кнопок удаления:', deleteButtons.length); // Проверка кнопок

    // Инициализация структуры для хранения товаров
    tabs.forEach(tab => {
        const tabName = tab.getAttribute('data-tab');
        selectedItems[tabName] = [];
    });

    // Обновление текущей вкладки
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            currentTab = tab.getAttribute('data-tab');
            console.log('Текущая вкладка:', currentTab);
        });
    });

    // Выделение строки при клике
    document.querySelectorAll('[id^="warehouse-table"]').forEach(table => {
        table.addEventListener('click', (event) => {
            const row = event.target.closest('tr');
            if (!row) return;

            const rowId = row.querySelector('td:first-child').innerText;
            const rowName = row.querySelector('td:nth-child(2)').innerText;
            const rowAmount = row.querySelector('td:nth-child(3)').innerText;

            const tabItems = selectedItems[currentTab];

            if (row.classList.contains('selected')) {
                row.classList.remove('selected');
                selectedItems[currentTab] = tabItems.filter(item => item.id !== rowId);
            } else {
                row.classList.add('selected');
                tabItems.push({ id: rowId, name: rowName, amount: rowAmount });
            }

            console.log('Выбранные товары:', selectedItems[currentTab]);
        });
    });

    // Обработчик для кнопок перемещения
    moveButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log('Кнопка перемещения нажата');
            selectedItemsList.innerHTML = '';
            const tabItems = selectedItems[currentTab];

            tabItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${item.name} - ${item.amount} шт.
                    <input type="number" min="1" max="${item.amount}" value="1" data-id="${item.id}" style="width: 60px;">
                `;
                selectedItemsList.appendChild(listItem);
            });

            if (tabItems.length > 0) {
                movePopup.classList.remove('hidden');
            } else {
                alert('Выберите товары для перемещения.');
            }
        });
    });

    // Закрытие попапа перемещения
    closeMovePopupButton.addEventListener('click', () => {
        movePopup.classList.add('hidden');
    });

    // Подтверждение перемещения
    confirmMoveButton.addEventListener('click', () => {
        const updatedItems = [];
        const inputs = selectedItemsList.querySelectorAll('input');

        inputs.forEach(input => {
            const itemId = input.getAttribute('data-id');
            const newAmount = parseInt(input.value);
            const item = selectedItems[currentTab].find(i => i.id === itemId);
            if (item && newAmount > 0) {
                updatedItems.push({ ...item, newAmount });
            }
        });

        if (updatedItems.length === 0) {
            alert('Выберите товары и укажите корректное количество.');
            movePopup.classList.add('hidden');
            return;
        }

        const source_warehouse_id = currentTab === 'warehouseOOO' ? 1 : 2;
        const destination_warehouse_id = source_warehouse_id === 1 ? 2 : 1;

        const productsToMove = updatedItems.map(item => ({
            product_id: item.id,
            quantity: item.newAmount
        }));

        fetch('/admin/dashboard/goods_and_services/moveProducts', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                source_warehouse_id,
                destination_warehouse_id,
                products: productsToMove
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Товары успешно перемещены');
                movePopup.classList.add('hidden');
                location.reload();
            } else {
                alert('Ошибка при перемещении товаров: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Произошла ошибка при перемещении товаров');
        });
    });

    // Обработчик для кнопок удаления
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log('Кнопка удаления нажата');
            deleteItemsList.innerHTML = '';
            const tabItems = selectedItems[currentTab];


            tabItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = item.name;
                deleteItemsList.appendChild(listItem);
            });

            console.log('Попап удаления должен открыться');
            if (tabItems.length > 0) {
                deletePopup.classList.remove('hidden');
            } else {
                alert('Выберите товары для удаления.');
            }
        });
    });

    // Закрытие попапа удаления
    cancelDeleteButton.addEventListener('click', () => {
        console.log('Отмена удаления нажата');
        deletePopup.classList.add('hidden');
    });

    // Подтверждение удаления
    confirmDeleteButton.addEventListener('click', () => {
        console.log('Подтверждение удаления нажато');
        const tabItems = selectedItems[currentTab];
        const productIds = tabItems.map(item => item.id);

        fetch('/admin/dashboard/goods_and_services/deleteProducts', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_ids: productIds,
                warehouse_id: currentTab === 'warehouseOOO' ? 1 : 2
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Товары успешно удалены');
                deletePopup.classList.add('hidden');
                location.reload();
            } else {
                alert('Ошибка при удалении товаров: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Произошла ошибка при удалении товаров');
        });
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const closeButton = document.querySelector('.close');
    const modal = document.getElementById('editModal');
    
    if (closeButton) {
        closeButton.addEventListener('click', closeEditModal);
    }
    
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeEditModal();
        }
    });
});

function openEditModal(id) {
    console.log(`Открытие модального окна для контрагента с ID: ${id}`);
    if (!Number.isInteger(id) || id <= 0) {
        console.error(`Некорректный ID: ${id}`);
        alert('Ошибка: Неверный ID контрагента');
        return;
    }
    fetch(`/admin/dashboard/company_managments/getSupplier/${id}`)
        .then(response => {
            console.log(`Статус ответа: ${response.status}`);
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Ошибка HTTP: ${response.status}, Ответ: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(`Ошибка от сервера: ${data.error}`);
                alert(data.error);
                return;
            }
            console.log('Полученные данные:', data);
            if (data.id != id) {
                console.error(`Несоответствие ID: Запрошен ${id}, получен ${data.id}`);
                alert(`Ошибка: Получены данные другого контрагента (ID: ${data.id})`);
                return;
            }
            document.getElementById('editId').value = data.id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editInn').value = data.inn;
            document.getElementById('editOgrn').value = data.ogrn;
            document.getElementById('editLegalAddress').value = data.legal_address;
            document.getElementById('editActualAddress').value = data.actual_address;
            document.getElementById('editPhone').value = data.phone;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editContactInfo').value = data.contact_info;
            const modal = document.getElementById('editModal');
            modal.style.display = 'block';
            setTimeout(() => modal.classList.add('show'), 10);
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Не удалось загрузить данные контрагента: ' + error.message);
        });
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

function confirmDelete(id) {
    if (confirm('Вы уверены, что хотите удалить этого контрагента?')) {
        window.location.href = `/admin/dashboard/company_managments/deleteSupplier/${id}`;
    }
}









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





