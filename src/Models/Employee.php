<?php

namespace Source\Models;

class Employee
{
    public function __construct(
        private int $id,
        private int $user_id
    ) {
        
    }

    public function id()
    {
        return $this->id;
    }

    public function user_id()
    {
        return $this->user_id;
    }
}
