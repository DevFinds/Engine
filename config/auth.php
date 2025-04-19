<?php

// В данном массиве лежат имена таблицы и столбцов из которых будут проверяться данные авторизации

return [

    'table' => 'User',
    'login_field_type' => 'login',
    'password' => 'password',
    'session_field' => 'user_id'
];
