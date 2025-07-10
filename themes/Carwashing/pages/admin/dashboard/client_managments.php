<?php

/**
 * @var \Core\RenderInterface $render
 * @var \Core\Session\SessionInterface $session
 * @var \Core\Auth\AuthInterface $auth
 */

$clients = $data['clients'];
?>

<?php $render->component('dashboard_header'); ?>
<!-- Сайдбар с меню -->
<?php $render->component('menu_sidebar'); ?>
<!-- Тело страницы -->
<!-- Контейнер с содержимым страницы -->
<div class="page-content-container">
    <!-- Содержимое страницы -->
    <div class="page-content">

        <?php $render->component('pagecontent_header'); ?>


        <!-- Содержимое страницы -->
        <div class="page-content-body">

                <?php if ($session->has('error')): ?>
                    <p style="color: red;"><?php echo $session->get('error'); $session->remove('error'); ?></p>
                <?php endif; ?>
                <?php if ($session->has('success')): ?>
                    <p style="color: green;"><?php echo $session->get('success'); $session->remove('success'); ?></p>
                <?php endif; ?>
            <?php foreach ([
                'name', 'inn', 'ogrn', 'legal_address', 'actual_address', 'phone', 'email', 'contact_info'] as $field): ?>
                    <?php if ($session->has($field)): ?>
                        <p style="color: red;"><?php echo implode(', ', $session->get($field)); $session->remove($field); ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <div class="clients-header-row">
                
                <button class="client-button" id="openAddClientModal">Добавить клиента</button>
                </div>
            <h2 class="clients-title">Список клиентов</h2>
            <div class="clients-table">
                        <table>
                            <thead>
                                <tr>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                                    <th>Телефон</th>
                            <th>Номера машин</th>
                            <th>Марки машин</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($client['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($client['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($client['patronymic']); ?></td>
                                <td><?php echo htmlspecialchars($client['phone']); ?></td>
                                <td><?php echo htmlspecialchars($client['state_numbers']); ?></td>
                                <td><?php echo htmlspecialchars($client['car_brands']); ?></td>
                                <td>
                                    <div class="clients-action-buttons">
                                        <button class="clients-edit-button" data-id="<?php echo $client['id']; ?>" title="Редактировать">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.5858 3.58579C14.3668 2.80474 15.6332 2.80474 16.4142 3.58579C17.1953 4.36683 17.1953 5.63316 16.4142 6.41421L15.6213 7.20711L12.7929 4.37868L13.5858 3.58579Z" fill="#707FDD"/>
                                                        <path d="M11.3787 5.79289L3 14.1716V17H5.82843L14.2071 8.62132L11.3787 5.79289Z" fill="#707FDD"/>
                                                    </svg>
                                                </button>
                                        <button class="clients-delete-button" data-id="<?php echo $client['id']; ?>" title="Удалить">
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 2H14V4H6V2Z" fill="#707FDD"/>
                                                        <path d="M4 6H16V18C16 19.1 15.1 20 14 20H6C4.9 20 4 19.1 4 18V6Z" fill="#707FDD"/>
                                                        <path d="M8 9H10V16H8V9Z" fill="#707FDD"/>
                                                        <path d="M12 9H14V16H12V9Z" fill="#707FDD"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
            </div>

            <!-- Модальное окно для добавления клиента -->
            <div id="addClientModal" class="clients-modal">
                <div class="clients-modal-content clients-modal-content--large">
                    <span class="clients-close" id="closeAddClientModal">&times;</span>
                    <h2 id="clientModalTitle">Добавить клиента</h2>
                    <form action="/admin/dashboard/client_managments/addClient" method="post" id="clients-tab-container-form" autocomplete="off">
                        <input type="hidden" name="id" id="clientIdInput" autocomplete="off">
                        <label for="last_name">Фамилия</label>
                        <input type="text" name="last_name" id="lastNameInput" autocomplete="off">
                        <label for="first_name">Имя</label>
                        <input type="text" name="first_name" id="firstNameInput" required autocomplete="off">
                        <label for="patronymic">Отчество</label>
                        <input type="text" name="patronymic" id="patronymicInput" autocomplete="off">
                        <label for="phone">Номер телефона</label>
                        <input type="text" name="phone" id="clientPhoneInput" required autocomplete="off">
                        <div id="carsContainer">
                            <label>Машины</label>
                            <div class="client-car-fields">
                                <input type="text" name="car_state_number[]" class="car-state-number-input" placeholder="Номер машины" required autocomplete="off">
                                <input type="text" name="car_brand[]" placeholder="Марка" required autocomplete="off">
                                <button type="button" class="add-car-btn">+</button>
                            </div>
                        </div>
                        <button type="submit" class="client-button" id="clientFormSubmitBtn">Добавить клиента</button>
                        </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://unpkg.com/inputmask@5.0.8/dist/inputmask.min.js"></script>
<script>
// Маска для телефона
Inputmask({ mask: "+7 (999) 999-99-99" }).mask(document.getElementById('clientPhoneInput'));
// Вместо этого реализуем фильтрацию ввода только разрешённых символов и автоматическое приведение к верхнему регистру
function setupCarNumberInputs() {
    document.querySelectorAll('.car-state-number-input').forEach(function(input) {
        input.addEventListener('input', function(e) {
            // Оставляем только разрешённые буквы и цифры
            let value = this.value
                .toUpperCase()
                .replace(/[^АВЕКМНОРСТУХ0-9]/g, '');
            // Ограничиваем длину (1 буква + 3 цифры + 2 буквы + до 3 цифр = максимум 8)
            value = value.slice(0, 9);
            this.value = value;
        });
    });
}
setupCarNumberInputs();
// Добавление новых полей для машин
const carsContainer = document.getElementById('carsContainer');
document.querySelector('.add-car-btn').onclick = function(e) {
    e.preventDefault();
    const div = document.createElement('div');
    div.className = 'client-car-fields';
    div.innerHTML = `<input type="text" name="car_state_number[]" class="car-state-number-input" placeholder="Номер машины" required autocomplete="off">
    <input type="text" name="car_brand[]" placeholder="Марка" required autocomplete="off">
    <button type="button" class="add-car-btn">+</button>`;
    carsContainer.appendChild(div);
    setupCarNumberInputs();
    div.querySelector('.remove-car-btn').onclick = function() { div.remove(); };
    div.querySelector('.add-car-btn').onclick = function(e) {
        e.preventDefault();
        document.querySelector('.add-car-btn').click();
    };
};
document.addEventListener('DOMContentLoaded', function() {
    var openBtn = document.getElementById('openAddClientModal');
    var modal = document.getElementById('addClientModal');
    var closeBtn = document.getElementById('closeAddClientModal');
    if (openBtn && modal && closeBtn) {
        // openBtn.onclick = function() {
        //     modal.style.display = 'flex';
        //     setTimeout(function(){modal.classList.add('show');}, 10);
        // };
        closeBtn.onclick = function() {
            modal.classList.remove('show');
            setTimeout(function(){modal.style.display = 'none';}, 300);
        };
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                setTimeout(function(){modal.style.display = 'none';}, 300);
            }
        };
    }
});

document.getElementById('clients-tab-container-form').addEventListener('submit', function(e) {
    // Проверка на дубли номеров машин
    const stateNumbers = Array.from(document.querySelectorAll('.car-state-number-input')).map(i => i.value.trim());
    const uniqueNumbers = new Set(stateNumbers);
    if (stateNumbers.length !== uniqueNumbers.size) {
        alert('У клиента не может быть две машины с одинаковым номером!');
        e.preventDefault();
        return;
    }
    e.preventDefault();
    const form = this;
    const id = form.clientIdInput.value;
    const isEdit = id && id !== '';
    console.log('ID для редактирования:', id, 'isEdit:', isEdit);
    const formData = new FormData(form);
    const url = isEdit ? '/admin/dashboard/client_managments/editClient' : '/admin/dashboard/client_managments/addClient';
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('addClientModal').classList.remove('show');
            setTimeout(function(){
                document.getElementById('addClientModal').style.display = 'none';
            }, 300);
            form.reset();
            location.reload();
        } else {
            alert('Ошибка при сохранении клиента: ' + (data.message || ''));
        }
    })
    .catch(() => alert('Ошибка при отправке запроса'));
});

document.querySelectorAll('.clients-delete-button').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const clientId = this.getAttribute('data-id');
        if (!clientId) return;
        if (!confirm('Вы уверены, что хотите удалить этого клиента?')) return;

        fetch('/admin/dashboard/client_managments/deleteClient', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(clientId)
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Удаляем строку из таблицы без перезагрузки
                const row = this.closest('tr');
                if (row) row.remove();
            } else {
                alert('Ошибка при удалении клиента');
            }
        })
        .catch(() => alert('Ошибка при отправке запроса'));
    });
});

// --- Функция для добавления новой строки машины ---
function addCarField(state_number = '', car_brand = '', canRemove = false) {
    const carsContainer = document.getElementById('carsContainer');
    const div = document.createElement('div');
    div.className = 'client-car-fields';
    div.innerHTML = `<input type="text" name="car_state_number[]" class="car-state-number-input" placeholder="Номер машины" required value="${state_number}" autocomplete="off">
    <input type="text" name="car_brand[]" placeholder="Марка" required value="${car_brand}" autocomplete="off">
    <button type="button" class="add-car-btn">+</button>` + (canRemove ? '<button type="button" class="remove-car-btn">-</button>' : '');
    carsContainer.appendChild(div);
    setupCarNumberInputs();
    div.querySelector('.add-car-btn').onclick = function(e) {
        e.preventDefault();
        addCarField('', '', true);
    };
    if (canRemove) {
        div.querySelector('.remove-car-btn').onclick = function() { div.remove(); };
    }
}
// --- Редактирование клиента ---
document.querySelectorAll('.clients-edit-button').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const clientId = this.getAttribute('data-id');
        if (!clientId) return;
        fetch('/admin/dashboard/client_managments/getClient/' + clientId)
            .then(r => r.json())
            .then(data => {
                if (!data.success) return alert('Ошибка загрузки данных клиента');
                const client = data.client;
                var modal = document.getElementById('addClientModal');
                modal.style.display = 'flex';
                setTimeout(function(){modal.classList.add('show');}, 10);
                document.getElementById('clientModalTitle').textContent = 'Редактировать клиента';
                document.getElementById('clientFormSubmitBtn').textContent = 'Сохранить изменения';
                document.getElementById('clientIdInput').value = client.id;
                document.getElementById('lastNameInput').value = client.last_name;
                document.getElementById('firstNameInput').value = client.first_name;
                document.getElementById('patronymicInput').value = client.patronymic || '';
                document.getElementById('clientPhoneInput').value = client.phone;
                document.getElementById('lastNameInput').readOnly = false;
                document.getElementById('firstNameInput').readOnly = false;
                document.getElementById('patronymicInput').readOnly = false;
                document.getElementById('clientPhoneInput').readOnly = true;
                // Очищаем контейнер машин и добавляем все машины клиента
                const carsContainer = document.getElementById('carsContainer');
                carsContainer.innerHTML = '<label>Машины</label>';
                (client.cars.length ? client.cars : [{}]).forEach(function(car, idx) {
                    addCarField(car.state_number || '', car.car_brand || '', idx > 0);
                });
            });
    });
});
// --- Переключение режима модалки на "добавить" при открытии через кнопку ---
document.getElementById('openAddClientModal').onclick = function() {
    var modal = document.getElementById('addClientModal');
    // Всегда полностью закрываем модалку перед открытием
    modal.classList.remove('show');
    modal.style.display = 'none';

    // Сброс формы (если вдруг браузер что-то подставил)
    document.getElementById('clients-tab-container-form').reset();
    // Сбросить все поля и состояния
    document.getElementById('clientModalTitle').textContent = 'Добавить клиента';
    document.getElementById('clientFormSubmitBtn').textContent = 'Добавить клиента';
    document.getElementById('clientIdInput').value = '';
    document.getElementById('lastNameInput').value = '';
    document.getElementById('firstNameInput').value = '';
    document.getElementById('patronymicInput').value = '';
    document.getElementById('clientPhoneInput').value = '';
    document.getElementById('lastNameInput').readOnly = false;
    document.getElementById('firstNameInput').readOnly = false;
    document.getElementById('patronymicInput').readOnly = false;
    document.getElementById('clientPhoneInput').readOnly = false;
    // Очищаем контейнер машин полностью
    const carsContainer = document.getElementById('carsContainer');
    while (carsContainer.firstChild) {
        carsContainer.removeChild(carsContainer.firstChild);
    }
    // Добавляем только label и одну пустую строку
    const label = document.createElement('label');
    label.textContent = 'Машины';
    carsContainer.appendChild(label);
    addCarField('', '', false);

    // Открываем модалку заново
    modal.style.display = 'flex';
    setTimeout(function(){modal.classList.add('show');}, 10);
};
</script>

<?php $render->component('dashboard_footer'); ?>