<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;

class EmployeeService
{
	public function __construct(
        private DatabaseInterface $database
    )
    {
    }

    public function getEmployees()
    {
        
    }
}