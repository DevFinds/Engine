<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чек №<?= htmlspecialchars($check['check_number']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .check-container {
            width: 80mm;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .check-header {
            text-align: center;
            font-size: 14px;
        }

        .check-body {
            margin-top: 10px;
        }

        .check-footer {
            margin-top: 20px;
            text-align: left;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            text-align: left;
            font-size: 12px;
            padding: 4px;
            border-bottom: 1px solid #ddd;
        }

        @page {
            size: 80mm 160mm;
            /* Размер бумаги: ширина x высота */
            margin: 0;
            /* Убираем отступы */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .check-container {
                width: 80mm;
                height: auto;
                margin: 0 auto;
            }

            @page {
                size: 80mm 200mm;
                /* Указываем размеры страницы */
                margin: 0;
                /* Убираем поля */
            }

            h2 {
                text-align: left;
            }

            p {
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="check-container">
        <div class="check-header">
            <p>ТОВАРНЫЙ ЧЕК №<?= htmlspecialchars($check['check_number']) ?></p>
            <p>Дата: <?= htmlspecialchars($check['date']) ?></p>
            <p>Кассир: <?= htmlspecialchars($check['operator_name']) ?></p>
        </div>

        <div class="check-body">
            <table>
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= number_format($item['price'], 2, '.', ' ') ?> руб.</td>
                            <td><?= number_format($item['total'], 2, '.', ' ') ?> руб.</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="check-footer">
            <p>Итого: <?= number_format($check['total'], 2, '.', ' ') ?> руб.</p>
            <p>Наличные: <?= number_format($check['cash'], 2, '.', ' ') ?> руб.</p>
            <p>Карта: <?= number_format($check['card'], 2, '.', ' ') ?> руб.</p>
        </div>
    </div>

    <script>
        // Открываем окно печати автоматически
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>