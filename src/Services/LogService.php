<?php


namespace Source\Services;

use Core\Database\Database;

class LogService
{

	public function __construct(private Database $database)
    {
        
    }

    public function getLastActions()
    {
        $last_actions = $this->database->get('last_actions');
        header('Content-Type: application/json; charset=utf-8');
    
        // Кодируем и выводим
        echo json_encode($last_actions, JSON_UNESCAPED_UNICODE);
        exit; // прекращаем дальнейший рендеринг
    }

    public static function logAtLastActions()
    {
        
    }
}