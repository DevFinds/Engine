<?php


namespace Source\Services;

use Source\Models\Company;
use Source\Models\CompanyType;
use Core\Database\DatabaseInterface;

class CompanyService
{
    public function __construct(
        private DatabaseInterface $database
    ) {}

    /**
     * Возвращает массив со всеми компаниями
     * @return array of \Source\Models\Company
     */
    public function getCompanies()
    {
        return $this->database->get('Company');
        $companies = array_map(fn($company) =>
        new Company(
            $company['id'],
            $company['company_name'],
            $company['inn'],
            $company['ogrn'],
            $company['company_address'],
            $company['company_email'],
            $company['company_phone'],
            $company['company_type'],
            $company['kpp']
        ), $companies);

        return $companies;
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
        return $this->database->get('Company', ['company_type' => $type]) ? : [];
    }

    /**
     * Возвращает название типа компании
     * @param int $company_type_id
     * 
     * @return string
     */
    public function getCompanyType(int $company_type_id)
    {
        return $this->database->get('Company_type', ['id' => $company_type_id]);
        $company_type = new CompanyType($company_type['id'], $company_type['name']);
        return $company_type->name();
    }
}
