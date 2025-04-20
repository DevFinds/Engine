<?php


namespace Source\Services;

class ExcelExporter
{
    /** @var string Имя генерируемого файла */
    protected $filename;
    /** @var array Описание колонок */
    protected $columns = [];
    /** @var array Данные для заполнения */
    protected $data = [];

    /**
     * @param string $filename — имя .xls файла
     * @param array $columns — каждая запись:
     *   [
     *     'header' => 'Заголовок столбца',
     *     'key'    => 'ключ_в_данных',
     *     'format' => 'string'|'number',
     *     // для чисел: формат mso-number-format, например "#,##0.00"
     *     'number_format' => '#,##0.00'
     *   ]
     * @param array $data — массив ассоц. массивов с ключами из columns.key
     */
    public function __construct(string $filename, array $columns, array $data)
    {
        $this->filename = $filename;
        $this->columns  = $columns;
        $this->data     = $data;
    }

    /** Отправляет заголовки и выводит HTML‑таблицу */
    public function export(): void
    {
        // HTTP‑заголовки для Excel :contentReference[oaicite:3]{index=3}
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header("Content-Disposition: attachment; filename=\"{$this->filename}.xls\"");
        header('Pragma: no-cache');
        header('Expires: 0');

        // Мета‑директива для UTF-8 внутри HTML :contentReference[oaicite:4]{index=4}
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>";

        // Начало таблицы
        echo '<table border="1">';

        // Заголовок
        echo '<tr>';
        foreach ($this->columns as $col) {
            echo '<th>' . htmlspecialchars($col['header']) . '</th>';
        }
        echo '</tr>';

        // Строки данных
        foreach ($this->data as $row) {
            echo '<tr>';
            foreach ($this->columns as $col) {
                $value = $row[$col['key']] ?? '';
                if (isset($col['format']) && $col['format'] === 'number') {
                    // mso-number-format для чисел :contentReference[oaicite:5]{index=5}
                    $fmt = htmlspecialchars($col['number_format'] ?? '#,##0');
                    echo "<td style=\"mso-number-format:'{$fmt}'\">" . (float)$value . '</td>';
                } else {
                    // простой текст
                    echo '<td>' . htmlspecialchars((string)$value) . '</td>';
                }
            }
            echo '</tr>';
        }

        echo '</table>';
        exit;
    }
}
