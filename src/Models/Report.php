<?php

namespace Source\Models;

class Report
{
    public function __construct(
        private $id,
        private $type,
        private $generated_at,
        private $period_start,
        private $period_end,
        private $document_url
    ) {
    }

    public function id()
    {
        return $this->id;
    }

    public function type()
    {
        return $this->type;
    }

    public function generated_at()
    {
        return $this->generated_at;
    }

    public function period_start()
    {
        return $this->period_start;
    }

    public function period_end()
    {
        return $this->period_end;
    }

    public function document_url()
    {
        return $this->document_url;
    }
}
