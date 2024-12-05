<?php

namespace Source\Models;

class TaxSettings
{
    public function __construct(
        private $id,
        private $tax_mode,
        private $nds_rate
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function tax_mode()
    {
        return $this->tax_mode;
    }

    public function nds_rate()
    {
        return $this->nds_rate;
    }
}
