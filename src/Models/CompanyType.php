<?php


namespace Source\Models;

class CompanyType
{
    public function __construct(
        private int $id,
        private string $company_type_name
    ) {}

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->company_type_name;
    }
}
