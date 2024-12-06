<?php


namespace Source\Services;

use Core\Database\DatabaseInterface;

class CompanyService
{
    public function __construct(
        private DatabaseInterface $database
    ) {}

    /**
     * Возвращает массив со всеми компаниями
     * @return array
     */
    public function getCompanies(): array
    {
        return $this->database->get('Company');
    }

    /**
     * Возвращает массив компаний по заданному типу
     * 1 - партнер, 2 - постивщик
     * 
     * @param int $type
     * 
     * @return array
     */
    public function getCompanyByType(int $type): array
    {
        return $this->database->get('Company', ['type' => $type]);
    }
}
