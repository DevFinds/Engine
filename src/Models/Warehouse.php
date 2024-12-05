<?php

namespace Source\Models;

class Warehouse
{
    public function __construct(
        private $id,
        private $name,
        private $organization_id,
        private $location
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function organization_id()
    {
        return $this->organization_id;
    }

    public function location()
    {
        return $this->location;
    }
}
