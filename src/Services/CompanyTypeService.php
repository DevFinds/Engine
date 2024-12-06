<?php


namespace Source\Services;

use Source\Models\CompanyType;
use Core\Database\DatabaseInterface;
use Source\Models\Company;

class CompanyTypeService
{
    public function __construct(
        private DatabaseInterface $database
    ) {}

    /**
     * Возвращает все типы компаний.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->database->get('Company_type');
        $company_types = array_map(fn($company_type) =>
        new CompanyType(
            $company_type['id'],
            $company_type['company_type_name']
        ), $company_types);

        return $company_types;
    }
}
