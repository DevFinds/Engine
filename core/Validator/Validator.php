<?php

namespace Core\Validator;

use Core\Auth\AuthInterface;
use Core\Config\Config as ConfigConfig;
use Core\Database\DatabaseInterface;
use PSpell\Config;

use function PHPSTORM_META\type;

/**
 * Class Validator
 *
 * Выполняет валидацию данных формы на основе заданных правил.
 *
 * @package Core\Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * Массив ошибок валидации.
     *
     * @var array
     */
    private array $errors = [];

    /**
     * Данные для валидации.
     *
     * @var array
     */
    private array $data;

    /**
     * Массив меток для полей формы.
     *
     * @var array
     */
    private array $labels = [];

    /**
     * Экземпляр интерфейса аутентификации для проверки уникальности и существования данных.
     *
     * @var AuthInterface
     */
    private AuthInterface $auth;

    /**
     * Экземпляр интерфейса базы данных для выполнения запросов.
     *
     * @var DatabaseInterface
     */
    private DatabaseInterface $database;

    /**
     * Validator constructor.
     *
     * @param AuthInterface      $auth      Экземпляр интерфейса аутентификации.
     * @param DatabaseInterface  $database  Экземпляр интерфейса базы данных.
     */
    public function __construct(
        AuthInterface $auth,
        DatabaseInterface $database
    ) {
        $this->auth = $auth;
        $this->database = $database;
    }

    /**
     * Выполняет валидацию данных на основе заданных правил.
     *
     * @param array $data   Данные для валидации (обычно $_POST).
     * @param array $rules  Правила валидации в формате ['field' => ['rule1', 'rule2:parameter', ...], ...].
     * @param array $labels Массив меток для полей формы (опционально).
     *
     * @return bool Возвращает true, если все данные валидны, иначе false.
     */
    public function validate(array $data, array $rules, array $labels = []): bool
    {
        $this->errors = [];
        $this->data = $data;
        $this->labels = $labels;

        foreach ($rules as $key => $ruleSet) {
            // Получение метки для текущего поля, если она задана
            $label = $this->labels[$key] ?? $this->generateLabel($key);

            foreach ($ruleSet as $rule) {
                // Разделяем правило на имя и параметр, если есть
                $ruleParts = explode(':', $rule, 2);
                $ruleName = $ruleParts[0];
                $ruleValue = $ruleParts[1] ?? null;

                // Выполнение проверки правила
                $error = $this->validateRule($key, $label, $ruleName, $ruleValue);

                if ($error) {
                    $this->errors['validation_errors'][$key][] = $error;
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Возвращает массив ошибок валидации.
     *
     * @return array Массив ошибок валидации.
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Проверяет отдельное правило валидации для конкретного поля.
     *
     * @param string      $key        Имя поля (например, 'email').
     * @param string      $label      Метка поля для использования в сообщениях об ошибках.
     * @param string      $ruleName   Название правила валидации (например, 'required').
     * @param string|null $ruleValue  Значение параметра правила (например, '6' для 'min:6').
     *
     * @return string|false Возвращает сообщение об ошибке или false, если правило прошло.
     */
    private function validateRule(string $key, string $label, string $ruleName, string $ruleValue = null): string|false
    {
        $value = $this->data[$key] ?? null;

        switch ($ruleName) {
            case 'required':
                if ($this->isEmpty($value)) {
                    return "Поле \"$label\" обязательно для заполнения.";
                }
                break;

            case 'min':
                if ($this->isString($value) && mb_strlen($value) < (int)$ruleValue) {
                    return "Поле \"$label\" должно содержать не менее $ruleValue символов.";
                }
                if ($this->isNumeric($value) && $value < (int)$ruleValue) {
                    return "Поле \"$label\" должно быть не меньше $ruleValue.";
                }
                break;

            case 'max':
                if ($this->isString($value) && mb_strlen($value) > (int)$ruleValue) {
                    return "Поле \"$label\" должно содержать не более $ruleValue символов.";
                }
                if ($this->isNumeric($value) && $value > (int)$ruleValue) {
                    return "Поле \"$label\" должно быть не больше $ruleValue.";
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Поле \"$label\" должно содержать корректный email адрес.";
                }
                break;

            case 'confirmed':
                if ($value !== ($this->data["{$key}_confirmation"] ?? null)) {
                    return "Поле \"$label\" должно быть подтверждено.";
                }
                break;

            case 'already_exist':
            case 'unique':
                // Ожидается формат 'unique:table,column' или 'unique:table'
                [$table, $column] = $this->parseRuleValue($ruleValue, $key);
                if ($this->isValueExist($table, $column, $value)) {
                    return "Элемент с таким \"$label\" уже существует.";
                }
                break;

            case 'numeric':
                if (!is_numeric($value)) {
                    return "Поле \"$label\" должно быть числом.";
                }
                break;

            case 'integer':
                if (!filter_var($value, FILTER_VALIDATE_INT)) {
                    return "Поле \"$label\" должно быть целым числом.";
                }
                break;

            case 'regex':
                if (!preg_match($ruleValue, $value)) {
                    return "Поле \"$label\" имеет некорректный формат.";
                }
                break;

            case 'url':
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    return "Поле \"$label\" должно быть корректным URL.";
                }
                break;

            case 'date':
                if (!$this->isValidDate($value)) {
                    return "Поле \"$label\" должно быть корректной датой.";
                }
                break;

            case 'after':
                if (!$this->isValidDate($value) || !$this->isValidDate($ruleValue)) {
                    return "Поле \"$label\" содержит некорректную дату.";
                }
                if (strtotime($value) <= strtotime($ruleValue)) {
                    return "Поле \"$label\" должно быть датой после $ruleValue.";
                }
                break;

            case 'before':
                if (!$this->isValidDate($value) || !$this->isValidDate($ruleValue)) {
                    return "Поле \"$label\" содержит некорректную дату.";
                }
                if (strtotime($value) >= strtotime($ruleValue)) {
                    return "Поле \"$label\" должно быть датой до $ruleValue.";
                }
                break;

            case 'in':
                // $ruleValue содержит список допустимых значений, разделенных запятой
                $allowed = array_map('trim', explode(',', $ruleValue));
                if (!in_array($value, $allowed, true)) {
                    return "Поле \"$label\" должно быть одним из следующих значений: " . implode(', ', $allowed) . ".";
                }
                break;

            case 'not_in':
                // $ruleValue содержит список запрещенных значений, разделенных запятой
                $disallowed = array_map('trim', explode(',', $ruleValue));
                if (in_array($value, $disallowed, true)) {
                    return "Поле \"$label\" не должно иметь значение: " . implode(', ', $disallowed) . ".";
                }
                break;

            case 'required_if':
                // $ruleValue содержит условие в формате 'field,value'
                [$otherField, $otherValue] = $this->parseRuleValue($ruleValue, $key);
                $otherFieldValue = $this->data[$otherField] ?? null;
                if ($otherFieldValue === $otherValue && $this->isEmpty($value)) {
                    return "Поле \"$label\" обязательно для заполнения, когда \"$otherField\" равно \"$otherValue\".";
                }
                break;
            case 'required_array':
                if (!isset($this->data[$key]) || !is_array($this->data[$key]) || empty($this->data[$key])) {
                    return "Поле \"$label\" обязательно (нужен не пустой массив).";
                }
                break;


            // Добавьте другие правила валидации по необходимости

            default:
                // Если правило не распознано, игнорируем его или выбрасываем исключение
                return false;
        }

        return false;
    }

    /**
     * Проверяет, пусто ли значение.
     *
     * @param mixed $value Значение для проверки.
     *
     * @return bool Возвращает true, если значение пустое, иначе false.
     */
    private function isEmpty(mixed $value): bool
    {
        return empty($value) && $value !== '0';
    }

    /**
     * Проверяет, является ли значение строкой.
     *
     * @param mixed $value Значение для проверки.
     *
     * @return bool Возвращает true, если значение строка, иначе false.
     */
    private function isString(mixed $value): bool
    {
        return is_string($value);
    }

    /**
     * Проверяет, является ли значение числом.
     *
     * @param mixed $value Значение для проверки.
     *
     * @return bool Возвращает true, если значение числовое, иначе false.
     */
    private function isNumeric(mixed $value): bool
    {
        if (!is_int($value) || !is_float($value) || !is_double($value)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Проверяет, является ли строка корректной датой.
     *
     * @param string $date Строка, представляющая дату.
     *
     * @return bool Возвращает true, если строка является корректной датой, иначе false.
     */
    private function isValidDate(string $date): bool
    {
        return strtotime($date) !== false;
    }

    /**
     * Разбирает значение правила, извлекая таблицу и столбец.
     *
     * @param string|null $ruleValue Значение правила (например, 'users,email').
     * @param string      $key       Имя поля (для сообщений об ошибках).
     *
     * @return array Массив с таблицей и столбцом.
     */
    private function parseRuleValue(?string $ruleValue, string $key): array
    {
        if (!$ruleValue) {
            return [$this->getDefaultTable($key), $key];
        }

        $parts = explode(',', $ruleValue);
        $table = $parts[0];
        $column = $parts[1] ?? $key;

        return [$table, $column];
    }

    /**
     * Возвращает название таблицы по умолчанию для поля.
     *
     * @param string $key Имя поля.
     *
     * @return string Название таблицы.
     */
    private function getDefaultTable(string $key): string
    {
        // Здесь можно определить логику определения таблицы по имени поля
        // Например, если поле заканчивается на '_id', то таблица может быть в единственном числе
        if (substr($key, -3) === '_id') {
            return rtrim($key, '_id') . 's';
        }

        // По умолчанию возвращаем 'users'
        return 'User';
    }

    /**
     * Проверяет, существует ли значение в указанной таблице и столбце.
     *
     * @param string $table  Имя таблицы.
     * @param string $column Имя столбца.
     * @param mixed  $value  Проверяемое значение.
     *
     * @return bool Возвращает true, если значение существует, иначе false.
     */
    private function isValueExist(string $table, string $column, mixed $value): bool
    {
        // Используем метод first_found_in_db для проверки существования значения
        $result = $this->database->first_found_in_db($table, [$column => $value]);

        return $result !== null;
    }

    /**
     * Генерирует метку поля на основе его имени.
     *
     * @param string $key Имя поля.
     *
     * @return string Метка поля.
     */
    private function generateLabel(string $key): string
    {
        // Преобразуем snake_case или kebab-case в читаемый формат
        return ucwords(str_replace(['_', '-'], ' ', $key));
    }
}
