<?php

namespace Core\Event;

use Core\Event\EventInterface;

interface EventListenerInterface
{
    public function handle(EventInterface $event): void;
}
