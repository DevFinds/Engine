<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;

class StorageService
{
    public function __construct(
        private DatabaseInterface $database
    ) 
    {

    }

    public function getAllFromDB()
    {
        
    }
}
