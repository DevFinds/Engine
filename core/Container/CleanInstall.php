<?php


namespace Core\Container;

use PDO;
use Core\Config\Config;
use Core\Database\Database;

class CleanInstall
{

    private array $database_credentials;

    public function __construct(
        private Config $config,
        private Database $database,
        
    ) {

        $this->get_database_credentials_form();
        $this->database_credentials = [
            'driver' => $_POST['driver'],
            'host' => $_POST['host'],
            'port' => $_POST['port'],
            'database' => $_POST['database'],
            'user' => $_POST['user'],
            'password' => $_POST['password'],
            'charset' => $_POST['charset']
        ];

        // Установка базы данных в конфигурации при первом запуске приложения
        $this->setup_database(

            $this->database_credentials['driver'],
            $this->database_credentials['host'],
            $this->database_credentials['port'],
            $this->database_credentials['database'],
            $this->database_credentials['user'],
            $this->database_credentials['password'],
            $this->database_credentials['charset']
        );

        if ($this->check_database_credentials()) {
            
        }
        else {
            
        }
    }



    /**
     * Sets up the database configuration.
     *
     * @param string $driver   The database driver.
     * @param string $host     The database host.
     * @param string $port     The database port.
     * @param string $database The database name.
     * @param string $user     The database username.
     * @param string $password The database password.
     * @param string $charset  The database charset.
     * @return void
     */

    // Метод установки базы данных в конфигурации при первом запуске приложения
    public function setup_database(string $driver, string $host, string $port, string $database, string $user, string $password, string $charset)
    {
        $this->config->setJson('database.driver', $driver);
        $this->config->setJson('database.host', $host);
        $this->config->setJson('database.port', $port);
        $this->config->setJson('database.database', $database);
        $this->config->setJson('database.username', $user);
        $this->config->setJson('database.password', $password);
        $this->config->setJson('database.charset', $charset);
    }


    // Метод проверик подключения к БД
    public function check_database_credentials(): bool
    {

        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $database = $this->config->get('database.database');
        $user = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $charset = $this->config->get('database.charset');


        $pdo = new PDO("$driver:host=$host;port=$port;dbname=$database;charset=$charset", $user, $password);

        if ($pdo) {
            return true;
        }

        return false;
    }

    // Метод вывода формы для получения конфигурации БД
    public function get_database_credentials_form()
    {
        echo '<form method="post" action="">
            <label for="driver">Драйвер БД:</label>
            <input type="text" name="driver" id="driver" value="mysql" required>
            <label for="host">Хост БД:</label>
            <input type="text" name="host" id="host" value="database" required>
            <label for="port">Порт БД:</label>
            <input type="text" name="port" id="port" value="3306" required>
            <label for="database">Название БД:</label>
            <input type="text" name="database" id="database" value="lemp" required>
            <label for="user">Имя пользователя БД:</label>
            <input type="text" name="user" id="user" value="lemp" required>
            <label for="password">Пароль пользователя БД:</label>
            <input type="password" name="password" id="password" required>
            <label for="charset">Кодировка БД:</label>
            <input type="text" name="charset" id="charset" value="utf8" required>
            <input type="submit" value="Сохранить">
        </form>';
    }

}
