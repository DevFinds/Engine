<?php


namespace Source\Models;


class CarClasses
{
	
    public function __construct(
        private $id,
        private $name,
        private $markup
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

    public function markup()
    {
        return $this->markup;
    }
}