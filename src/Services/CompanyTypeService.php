<?php


namespace Source\Services;

use Source\Models\CompanyType;
use Core\Database\DatabaseInterface;

class CompanyTypeService
{
    public function __construct(
        private DatabaseInterface $database
    ) {}

    public function getAll()
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
