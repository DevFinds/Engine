<?php

namespace Source\Services;

use Core\Database\DatabaseInterface;

class CheckPrinterService
{
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Формирует содержимое чека для печати.
     *
     * @param int $checkId ID чека из таблицы checks.
     * @return string Содержимое чека в текстовом формате.
     * @throws \Exception Если чек не найден.
     */
    public function generateCheckContent(int $checkId): string
    {
        // Получаем данные чека из базы
        $check = $this->database->first_found_in_db('checks', ['id' => $checkId]);
        if (!$check) {
            throw new \Exception("Чек с ID $checkId не найден.");
        }

        // Получаем связанные элементы чека
        $checkItems = $this->database->get('check_items', ['check_id' => $checkId]);

        // Формируем содержимое чека
        $content = "========================================\n";
        $content .= "            ТОВАРНЫЙ ЧЕК\n";
        $content .= "========================================\n";
        $content .= "Номер чека: {$check['check_number']}\n";
        $content .= "Дата: {$check['date']}\n";
        $content .= "Оператор: {$check['operator_name']}\n";
        if ($check['license_plate']) {
            $content .= "Гос. номер: {$check['license_plate']}\n";
        }
        $content .= "----------------------------------------\n";
        $content .= "Наименование      Кол-во   Цена   Сумма\n";
        $content .= "----------------------------------------\n";

        foreach ($checkItems as $item) {
            $name = str_pad($item['name'], 16);
            $quantity = str_pad($item['quantity'], 7, ' ', STR_PAD_LEFT);
            $price = str_pad(number_format($item['price'], 2), 6, ' ', STR_PAD_LEFT);
            $total = str_pad(number_format($item['total'], 2), 6, ' ', STR_PAD_LEFT);
            $content .= "{$name}{$quantity}{$price}{$total}\n";
        }

        $content .= "----------------------------------------\n";
        $content .= "ИТОГО: " . number_format($check['total'], 2) . " руб.\n";
        $content .= "Наличными: " . number_format($check['cash'], 2) . " руб.\n";
        $content .= "Картой: " . number_format($check['card'], 2) . " руб.\n";
        $content .= "Сдача: " . number_format($check['change_amount'], 2) . " руб.\n";
        $content .= "========================================\n";

        return $content;
    }

    /**
     * Печатает чек на принтере.
     *
     * @param int $checkId ID чека из таблицы checks.
     * @throws \Exception Если чек не найден или произошла ошибка печати.
     */
    public function printCheck(int $checkId): void
    {
        $content = $this->generateCheckContent($checkId);

        // Реализация печати (пример для Linux/Windows)
        $printerName = "My_Printer"; // Имя вашего принтера
        $tmpFile = sys_get_temp_dir() . "/check_$checkId.txt";

        // Записываем содержимое чека во временный файл
        file_put_contents($tmpFile, $content);

        // Отправляем файл на печать
        if (PHP_OS_FAMILY === 'Windows') {
            exec("print /d:\"$printerName\" \"$tmpFile\"");
        } else {
            exec("lp -d \"$printerName\" \"$tmpFile\"");
        }

        // Удаляем временный файл
        unlink($tmpFile);
    }
}
