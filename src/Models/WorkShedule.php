<?php

namespace Source\Models;

class WorkSchedule
{
    public function __construct(
        private $id,
        private $name,
        private $work_days,
        private $rest_days,
        private $daily_hours
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

    public function work_days()
    {
        return $this->work_days;
    }

    public function rest_days()
    {
        return $this->rest_days;
    }

    public function daily_hours()
    {
        return $this->daily_hours;
    }
}
